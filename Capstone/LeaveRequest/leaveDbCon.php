<?php

require 'vendor/autoload.php';


define("DATABASE","demo_hris");
class DatabaseConnection
{
    private $server = "mysql:host=localhost;dbname=".DATABASE;
    private $user = "root";
    private $pass = "";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
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
}

class LeaveApplication extends DatabaseConnection
{
    public function submitLeaveApplication($data)
    {
        $leave_type = trim($data['leave_type']);
        $reason = trim($data['reason']);

        try {
            $connection = $this->connect();
            $stmt = $connection->prepare("INSERT INTO leave_application (leave_type, reason) VALUES (?, ?)");
            $stmt->execute([$leave_type, $reason]);
            return "Leave application submitted successfully!";
        } catch (PDOException $e) {
            return "Error submitting leave application: " . $e->getMessage();
        }
    }
}
