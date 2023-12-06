#include <Adafruit_Fingerprint.h>
#include <Wire.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <LiquidCrystal_I2C.h>

#if (defined(__AVR__) || defined(ESP8266)) && !defined(__AVR_ATmega2560__)
SoftwareSerial mySerial(2, 3);
#else
#define mySerial Serial2
#endif

const char *ssid = "Red Sus";
const char *password = "@m0n6u$2023";
IPAddress staticIP(10, 0, 0, 199);
IPAddress gateway(10, 0, 0, 1);
IPAddress subnet(255, 255, 255, 0);

Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

uint8_t id;
const char *serverStatus = "";
int fingerPrintId = 0;

LiquidCrystal_I2C lcd(0x27, 16, 2);

void displayOnLCD(const String &line1, const String &line2) {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print(line1);
  lcd.setCursor(0, 1);
  lcd.print(line2);
}

void setup() {
  Serial.begin(9600);
  while (!Serial)
    ;  // For Yun/Leo/Micro/Zero/...
  delay(2000);
  Serial.println("\n\nAdafruit Fingerprint sensor enrollment");
  connectToNetwork();

  lcd.init();
  lcd.backlight();

  //NOTE: UNCOMMENT THIS CODE ONCE WHEN PRESENTING, then recomment again and compile
  //finger.emptyDatabase();

  displayOnLCD("HR Information", "System");

  finger.begin(57600);

  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) {
      delay(1);
    }
  }

  Serial.println(F("Reading sensor parameter"));
  finger.getParameters();
  Serial.print(F("Status: 0x"));
  Serial.println(finger.status_reg, HEX);
  Serial.print(F("Sys ID: 0x"));
  Serial.println(finger.system_id, HEX);
  Serial.print(F("Capacity: "));
  Serial.println(finger.capacity);
  Serial.print(F("Security level: "));
  Serial.println(finger.security_level);
  Serial.print(F("Device address: "));
  Serial.println(finger.device_addr, HEX);
  Serial.print(F("Packet len: "));
  Serial.println(finger.packet_len);
  Serial.print(F("Baud rate: "));
  Serial.println(finger.baud_rate);

  delay(5000);
}

void loop() {
  getUserFingerprint();
  delay(1000); 
}

String checkServerStatus() {
  const char *url = "http://10.0.0.93/Capstone/esp32/check_status.php";
  //replace with actual server URL

  HTTPClient http;
  DynamicJsonDocument doc(1024);

  http.begin(url);

  int httpResponseCode = http.GET();

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);

    String response = http.getString();
    Serial.println(response);

    deserializeJson(doc, response);

    serverStatus = doc["server_status"];
    Serial.print("Server status: ");
    Serial.println(serverStatus);

    String fingerPrintIdString = doc["empty_fingerprint_id"];

    if (fingerPrintIdString.length() > 0) {
      fingerPrintId = fingerPrintIdString.toInt();
      id = fingerPrintId;
    }

    return serverStatus;
  } else {
    Serial.print("HTTP Request failed. Error code: ");
    Serial.println(httpResponseCode);
  }

  http.end();
  doc.clear();

  return ""; 
}

void getControllerAction(int p) {
  String status = checkServerStatus();

  if (status == "dtr") {
    Serial.println("DTR mode");
    uint8_t i = scanAndCheckFingerprint();
    checkFingerprintIdToServer(i);
  } else if (status == "enrolling") {
    Serial.println("Enrolling mode");
    enrollUser();
  }
}

void getUserFingerprint() {
  int p = -1;
  Serial.println("Place finger on the sensor");

  // Flag to control the loop
  bool continueLoop = true;

  while (continueLoop) {
    displayOnLCD("Waiting for a", "Fingerprint...");
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Fingerprint detected!");
        getControllerAction(p);
        break;
      case FINGERPRINT_NOFINGER:
        Serial.println("No finger detected");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
    delay(1000);
  }
}

void enrollUser() {
  Serial.println("Ready to enroll a fingerprint!");
  Serial.println(fingerPrintId);

  while (!getFingerprintEnroll())
    ;

  uint8_t userId = fingerPrintId;

  // Send the user's fingerprint ID to the server
  sendFingerprintIdToServer(userId);
}

uint8_t scanAndCheckFingerprint() {
  int p = finger.image2Tz(1);
  if (p != FINGERPRINT_OK) {
    return p;
  }

  // Use fingerFastSearch to find a matching fingerprint
  p = finger.fingerFastSearch();
  if (p == FINGERPRINT_OK) {
    Serial.print("Fingerprint matched with ID ");
    Serial.println(finger.fingerID);
    return finger.fingerID;
  } else if (p == FINGERPRINT_NOTFOUND) {
    Serial.println("Fingerprint not found");
    return 0;  // Return 0 if no match is found
  } else {
    Serial.println("Error searching for fingerprint");
    return p;
  }
}

uint8_t getFingerprintEnroll() {
  int p = -1;

  while (true)  // Infinite loop for retrying enrollment
  {
    Serial.print("Waiting for a valid finger to enroll as #");
    Serial.println(id);

    // Capture fingerprint image
    while (p != FINGERPRINT_OK) {
      displayOnLCD("Please put finger", "on the sensor...");
      p = finger.getImage();
      switch (p) {
        case FINGERPRINT_OK:
          Serial.println("Image taken");
          displayOnLCD("Image Taken,", "Proceeding...");
          delay(2000);
          break;
        case FINGERPRINT_NOFINGER:
          Serial.println(".");
          break;
        case FINGERPRINT_PACKETRECIEVEERR:
          Serial.println("Communication error");
          break;
        case FINGERPRINT_IMAGEFAIL:
          Serial.println("Imaging error");
          break;
        default:
          Serial.println("Unknown error during image capture");
          return p;
      }
    }

    // Convert image to template
    p = finger.image2Tz(1);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        return p;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        return p;
      case FINGERPRINT_FEATUREFAIL:
        Serial.println("Could not find fingerprint features");
        return p;
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        return p;
      default:
        Serial.println("Unknown error");
        return p;
    }

    // Prompt to remove finger
    Serial.println("Remove finger");
    displayOnLCD("Please remove", "your finger...");
    delay(2000);

    // Wait for finger removal
    p = 0;
    while (p != FINGERPRINT_NOFINGER) {
      p = finger.getImage();
    }

    // Enroll the fingerprint again
    Serial.print("Enrolling ID ");
    Serial.println(id);

    // Prompt to place the same finger again
    Serial.println("Place the same finger again");
    displayOnLCD("Place the same", "finger again...");
    while (p != FINGERPRINT_OK) {
      p = finger.getImage();
      switch (p) {
        case FINGERPRINT_OK:
          Serial.println("Image taken");
          displayOnLCD("Image Taken,", "Proceeding...");
          break;
        case FINGERPRINT_NOFINGER:
          Serial.print(".");
          break;
        case FINGERPRINT_PACKETRECIEVEERR:
          Serial.println("Communication error");
          break;
        case FINGERPRINT_IMAGEFAIL:
          Serial.println("Imaging error");
          break;
        default:
          Serial.println("Unknown error");
          return p;
      }
    }

    // Convert the second image to template
    p = finger.image2Tz(2);
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image converted");
        break;
      case FINGERPRINT_IMAGEMESS:
        Serial.println("Image too messy");
        return p;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        return p;
      case FINGERPRINT_FEATUREFAIL:
        Serial.println("Could not find fingerprint features");
        return p;
      case FINGERPRINT_INVALIDIMAGE:
        Serial.println("Could not find fingerprint features");
        return p;
      default:
        Serial.println("Unknown error");
        return p;
    }

    delay(2000);

    // Enrollment completed, create and store the model
    Serial.print("Creating model for #");
    Serial.println(id);

    // Create the model
    p = finger.createModel();
    if (p == FINGERPRINT_OK) {
      Serial.println("Prints matched!");
      displayOnLCD("Fingerprints", "matched!");
      break;  // Exit the loop if enrollment is successful
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
      Serial.println("Communication error during model creation");
    } else if (p == FINGERPRINT_ENROLLMISMATCH) {
      Serial.println("Fingerprints did not match during model creation");
      displayOnLCD("Fingerprints", "do not match!");
      delay(2000);
      displayOnLCD("Repeat again...", "");
      delay(2000);
      // Continue to the next iteration of the loop
    } else {
      Serial.println("Unknown error during model creation");
    }
  }

  // Store the model
  Serial.print("Storing model for ID ");
  Serial.println(id);

  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error during model storage");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error during model storage");
    return p;
  }

  // Return success
  return true;
}

void connectToNetwork() {
  WiFi.config(staticIP, gateway, subnet);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
  Serial.println("IP: " + WiFi.localIP().toString());
}

void checkFingerprintIdToServer(uint16_t fingerprintId) {
  const char *url = "http://10.0.0.93/Capstone/fingerprint_id/check_fingerprint_id.php";  // Update with actual server URL
  HTTPClient http;
  String postData = "fingerprint_id=" + String(fingerprintId);

  http.begin(url);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpResponseCode = http.POST(postData);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);

    String response = http.getString();
    Serial.println(response);

    StaticJsonDocument<512> doc;
    DeserializationError err = deserializeJson(doc, response);

    if (err) {
      Serial.println("Failed to parse JSON");
    } else {
      if (doc["employee_details"].containsKey("lname") && doc.containsKey("action")) {
        const char *lastName = doc["employee_details"]["lname"];
        const char *action = doc["action"];

        Serial.println(lastName);
        Serial.println(action);

        displayOnLCD("REEEEE", "BEEEE");

        if (strcmp(action, "time_in") == 0) {
          displayOnLCD("Time in for", lastName);
        } else if (strcmp(action, "time_out") == 0) {
          displayOnLCD("Time out for", lastName);
        }

        delay(2000);
      } else {
        Serial.println("Missing required fields in JSON response");
      }
    }
  } else {
    Serial.print("HTTP Request failed. Error code: ");
    Serial.println(httpResponseCode);
  }

  http.end();
}

void sendFingerprintIdToServer(uint8_t fingerprintId) {
  const char *url = "http://10.0.0.93/Capstone/fingerprint_id/save_fingerprint_id.php";  // Update with actual server URL
  HTTPClient http;
  String postData = "fingerprint_id=" + String(fingerprintId);

  http.begin(url);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpResponseCode = http.POST(postData);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);

    String response = http.getString();
    Serial.println(response);
  } else {
    Serial.print("HTTP Request failed. Error code: ");
    Serial.println(httpResponseCode);
  }

  http.end();
}
