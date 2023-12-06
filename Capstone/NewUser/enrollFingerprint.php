<?php
session_start();
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

// Create an instance of UpdateServerStatus
$updateServerStatus = new UpdateServerStatus();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enroll Fingerprint</title>

        <style>
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column; /* Added to stack elements vertically */
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            h1 {
                text-align: center;
                margin-bottom: 20px; /* Added space between heading and timer */
            }

            #timer {
                font-size: 20px;
                margin-bottom: 20px; /* Added space below timer */
            }

            #userEmail {
                font-size: 16px;
                font-style: italic;
            }
        </style>
    </head>
    <body>

        <h1>Now enroll the fingerprint data</h1>

        <div id="timer">5:00</div>
        
        <!-- Display user's email -->
        <div id="userEmail">Enrolling fingerprint for user: <?php echo $_SESSION['user_email']; ?></div>

        <script>
            var timer = sessionStorage.getItem('timer') || 120; // 5 minutes in seconds

            function updateTimer() {
                var minutes = Math.floor(timer / 60);
                var seconds = timer % 60;

                // Add leading zero if needed
                minutes = (minutes < 10) ? "0" + minutes : minutes;
                seconds = (seconds < 10) ? "0" + seconds : seconds;

                document.getElementById('timer').innerText = minutes + ':' + seconds;
            }

            function checkFingerprintEnrollment() {
                // Use AJAX to check the fingerprint enrollment status
                var emailToCheck = <?php echo json_encode($_SESSION['user_email']); ?>;
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'checkEnrollmentStatus.php?email=' + encodeURIComponent(emailToCheck), true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var isEnrolled = JSON.parse(xhr.responseText);
                        if (isEnrolled) {
                            alert('Fingerprint enrollment is successful for user: ' + emailToCheck + '!');
                            sessionStorage.clear(); // Remove all session fields

                            updateServerStatus('dtr');

                            window.location.href = '../user-add.php';
                        }
                    }
                };
                xhr.send();
            }

            function updateServerStatus(status) {
                // Use AJAX to update server status
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'updateStatus.php?status=' + encodeURIComponent(status), true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log('Server status updated to ' + status);
                    } else {
                        console.error('Error updating server status: ' + xhr.statusText);
                    }

                    // Display alert when the timer expires
                    if (timer <= 0) {
                        alert('Fingerprint enrollment time expired! Re-enter the employee information and try again.');
                        sessionStorage.removeItem('timer');
                    }
                };
                xhr.send();
            }

            function decrementTimer() {
                if (timer > 0) {
                    timer--;
                    updateTimer();
                    sessionStorage.setItem('timer', timer);

                    // Call checkFingerprintEnrollment every time the timer decrements
                    checkFingerprintEnrollment();

                    setTimeout(decrementTimer, 1000);
                } else {
                    // Call updateServerStatus after the timer is zero or less than zero
                    updateServerStatus('dtr');
                }
            }

            // Call the method to update server status to 'enrolling' when the page loads
            <?php $updateServerStatus->updateServerStatus('enrolling'); ?>
            console.log('User email: ' + <?php echo json_encode($_SESSION['user_email']); ?>);

            // Start the countdown
            decrementTimer();
        </script>


    </body>
</html>
