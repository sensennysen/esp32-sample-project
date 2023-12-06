<?php
// Set the appropriate content type header
header("Content-Type: application/json");

// Include the necessary files and classes
require '../NewUser/vendor/autoload.php';

define("DATABASE", "demo_hris");

class ServerStatus
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

    public function getServerStatus()
    {
        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("
                SELECT status
                FROM server_to_hw_status
                WHERE action_key = 'dbhris'
            ");

            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                return $result['status'];
            } else {
                return 'unknown';
            }
        } catch (PDOException $e) {
            echo "There is an error: " . $e->getMessage();
        }
    }

    public function getEmptyFingerprintId()
    {
        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("
                SELECT id
                FROM add_new_user
                WHERE fingerprint_id IS NULL OR fingerprint_id = ''
                LIMIT 1
            ");

            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                return $result['id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "There is an error: " . $e->getMessage();
        }
    }
}

// Create an instance of ServerStatus
$serverStatus = new ServerStatus();

// Check if the server is reachable
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $currentStatus = $serverStatus->getServerStatus();
    $emptyFingerprintId = $serverStatus->getEmptyFingerprintId();

    $response = array(
        'status' => 'success',
        'message' => 'Server is reachable',
        'server_status' => $currentStatus,
        'empty_fingerprint_id' => $emptyFingerprintId,
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method',
    );
}

// Output the JSON response
echo json_encode($response);
?>
