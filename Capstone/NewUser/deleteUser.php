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

    public function deleteFromAddNewUser($email)
    {
        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("
                DELETE FROM add_new_user
                WHERE email = :email
            ");

            $stmt->bindParam(':email', $email);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "There is an error: " . $e->getMessage();
        }
    }
}

// Check if the email parameter is set
if (isset($_GET['email'])) {
    $emailToDelete = $_GET['email'];

    // Create an instance of UpdateServerStatus
    $updateServerStatus = new UpdateServerStatus();

    // Delete user from add_new_user table
    $updateServerStatus->deleteFromAddNewUser($emailToDelete);
    echo 'User deleted from add_new_user table';
} else {
    echo 'Email parameter not provided';
}
?>
