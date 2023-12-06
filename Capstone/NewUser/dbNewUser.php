<?php
    session_start();
    require 'vendor/autoload.php';

    define("DATABASE", "demo_hris");
    class AddNewUser
    {
        private $server = "mysql:host=localhost;dbname=" . DATABASE;
        private $user = "root";
        private $pass =  "";
        private $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        protected $con;

        public function connect()
        {
            try {
                $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
                return $this->con;
            } catch (PDOException $e) {
                echo "There is an error: " . $e->getMessage();
            }
        }

        public function insertUser($formData)
        {
            try {
                $connection = $this->connect();
                $stmt = $connection->prepare("
                INSERT INTO add_new_user (
                    upload_Image,
                    department,
                    fUrl,
                    email,
                    fname,
                    lname,
                    MiddleInitial,
                    Suffix,
                    gender,
                    MobNo,
                    AltCon,
                    birthDate,
                    StreetAdd,
                    city,
                    country,
                    pno,
                    province,
                    uname,
                    password
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

                $stmt->execute([
                    $formData['upload_Image'],
                    $formData['department'],
                    $formData['fUrl'],
                    $formData['email'],
                    $formData['fname'],
                    $formData['lname'],
                    $formData['MiddleInitial'],
                    $formData['Suffix'],
                    $formData['gender'],
                    $formData['MobNo'],
                    $formData['AltCon'],
                    $formData['birthDate'],
                    $formData['StreetAdd'],
                    $formData['city'],
                    $formData['country'],
                    $formData['pno'],
                    $formData['province'],
                    $formData['uname'],
                    password_hash($formData['password'], PASSWORD_DEFAULT) // Hash the password
                ]);
                echo "<style>
            .floating-alert {
                position: relative;
                top: 20px;
                right: 20px;
                z-index: 9999;
                background-color: #1c3ab6;
                color: #fff;
                padding: 10px;
                border-radius: 5px;
            }
        </style>";

                echo "<div class='floating-alert'>Success!</div>";
                // Redirect back to the form page
                //can be modified
                $_SESSION['user_email'] = $formData['email'];
                header("Location: ../NewUser/enrollFingerprint.php");
                exit();
            } catch (PDOException $e) {
                echo "There is an error: " . $e->getMessage();
            }
        }
    }
