<?php
require 'vendor/autoload.php';

define("DATABASE", "demo_hris");

class UpdateServerStatus
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

    public function updateServerStatus($status)
    {
        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("
                UPDATE server_to_hw_status
                SET status = :status
                WHERE action_key = 'dbhris'
            ");

            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "There is an error: " . $e->getMessage();
        }
    }
}

// Check if the status parameter is set
if (isset($_GET['status'])) {
    $status = $_GET['status'];

    // Create an instance of UpdateServerStatus
    $updateServerStatus = new UpdateServerStatus();

    // Update server status
    $updateServerStatus->updateServerStatus($status);
    echo 'Server status updated to "' . $status . '"';
} else {
    echo 'Status parameter not provided';
}
?>
