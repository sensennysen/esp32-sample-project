<?php
session_start();
require 'vendor/autoload.php';

define("DATABASE", "demo_hris");

class EnrollmentStatusChecker
{
    private $server = "mysql:host=localhost;dbname=" . DATABASE;
    private $user = "root";
    private $pass = "";
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

    public function checkEnrollmentStatus($email)
    {
        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("
                SELECT fingerprint_id
                FROM add_new_user
                WHERE email = :email
            ");

            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $result = $stmt->fetch();
            return !empty($result['fingerprint_id']);
        } catch (PDOException $e) {
            echo "There is an error: " . $e->getMessage();
        }
    }
}

// Handle the AJAX request
if (isset($_GET['email'])) {
    $emailToCheck = $_GET['email'];

    // Create an instance of EnrollmentStatusChecker
    $enrollmentStatusChecker = new EnrollmentStatusChecker();
    
    // Check enrollment status
    $isEnrolled = $enrollmentStatusChecker->checkEnrollmentStatus($emailToCheck);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($isEnrolled);
    exit();
} else {
    // Invalid request
    header('HTTP/1.1 400 Bad Request');
    exit();
}
?>
