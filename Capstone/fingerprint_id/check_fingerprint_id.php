<?php
// FILEPATH: /c:/xampp/htdocs/Capstone/esp32/checkfingerprint.php
include '../dbConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive the fingerprint ID from the ESP32 request
    $fingerprintId = $_POST['fingerprint_id'];

    // Prepare an SQL statement to search for the hashed fingerprint ID in the employees table
    $searchEmployeeStmt = $pdo->prepare("SELECT id, fname, lname, email FROM employees WHERE fingerprint_id = ?");
    $searchEmployeeStmt->bindParam(1, $fingerprintId);
    $searchEmployeeStmt->execute();

    // Check if a row with the hashed fingerprint ID is found
    if ($searchEmployeeStmt->rowCount() > 0) {
        // Fetch the employee details from the result
        $employeeDetails = $searchEmployeeStmt->fetch(PDO::FETCH_ASSOC);
        $employeeId = $employeeDetails['id'];

        // Check for existing DTR record for the employee and today's date
        $searchDTRStmt = $pdo->prepare("SELECT * FROM dtr_record WHERE employee_number = ? AND date = CURDATE()");
        $searchDTRStmt->bindParam(1, $employeeId);
        $searchDTRStmt->execute();

        if ($searchDTRStmt->rowCount() == 0) {
            // No DTR record for today, create a new record with 'time_in'
            $action = 'time_in';
            $insertDTRStmt = $pdo->prepare("INSERT INTO dtr_record (employee_number, action, date, time) VALUES (?, ?, CURDATE(), CURTIME())");
            $insertDTRStmt->bindParam(1, $employeeId);
            $insertDTRStmt->bindParam(2, $action);
            $insertDTRStmt->execute();
        } else {
            // DTR record for today exists, check the last entry
            $lastDTRStmt = $pdo->prepare("SELECT * FROM dtr_record WHERE employee_number = ? AND date = CURDATE() ORDER BY time DESC LIMIT 1");
            $lastDTRStmt->bindParam(1, $employeeId);
            $lastDTRStmt->execute();
            
            $lastEntry = $lastDTRStmt->fetch(PDO::FETCH_ASSOC);

            // Determine the next action based on the last entry
            $action = ($lastEntry['action'] == 'time_in') ? 'time_out' : 'time_in';

            // Create a new record for the determined action
            $insertDTRStmt = $pdo->prepare("INSERT INTO dtr_record (employee_number, action, date, time) VALUES (?, ?, CURDATE(), CURTIME())");
            $insertDTRStmt->bindParam(1, $employeeId);
            $insertDTRStmt->bindParam(2, $action);
            $insertDTRStmt->execute();
        }

        $response = [
            'status' => 'success',
            'message' => 'DTR record updated successfully',
            'employee_details' => $employeeDetails,
            'action' => $action
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No matching fingerprint ID found in employees table'
        ];
    }

    // Send a response back to the ESP32
    echo json_encode($response);

    // Close the statements
    $searchEmployeeStmt = null;
    $searchDTRStmt = null;
    $insertDTRStmt = null;
    $lastDTRStmt = null;
} else {
    // Invalid request method
    http_response_code(405);
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method'
    ];
    echo json_encode($response);
}
?>
