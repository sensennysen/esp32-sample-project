<?php

include 'dbConn.php';

function login($username, $password)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM add_new_user WHERE email = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}

// Check if the user is logged in
function isLoggedIn()
{
    return isset($_SESSION['NewUserId']);
}

// Check if the user has admin privileges
function isAdmin()
{
    return isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'admin';
}

// Check if the user has user privileges
function isEmployee()
{
    return isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'employee';
}

// Perform login when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];
    $user = login($username, $password);
    if ($user) {
        // Set session variables
        $_SESSION['NewUserId'] = $user['id'];
        $_SESSION['userRole'] = $user['userRole'];
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
        if (isAdmin()) {
            $adminLocation = 'Adminhome.php';
            echo '<html>
                    <head>
                        <style>
                            .loading-container {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                height: 100vh;
                                font-family: Arial, sans-serif;
                            }
                            
                            .loading-spinner {
                                border: 8px solid #f3f3f3;
                                border-top: 8px solid #3498db;
                                border-radius: 50%;
                                width: 60px;
                                height: 60px;
                                animation: spin 1s linear infinite;
                            }
                            
                            .loading-text {
                                margin-top: 20px;
                                font-size: 24px;
                            }
                            
                            @keyframes spin {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="loading-container">
                            <div class="loading-spinner"></div>
                            <div class="loading-text">Welcome! Admin '.$user['fname'].'.</div>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "'.$adminLocation.'";
                            }, 2000); // Redirect after 3 seconds
                        </script>
                    </body>
                </html>';
            exit;
        } elseif (isEmployee()) {
            $employeeLocation = 'Employeehome.php';
            echo '<html>
                    <head>
                        <style>
                            .loading-container {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                height: 100vh;
                                font-family: Arial, sans-serif;
                            }
                            
                            .loading-spinner {
                                border: 8px solid #f3f3f3;
                                border-top: 8px solid #3498db;
                                border-radius: 50%;
                                width: 60px;
                                height: 60px;
                                animation: spin 1s linear infinite;
                            }
                            
                            .loading-text {
                                margin-top: 20px;
                                font-size: 24px;
                            }
                            
                            @keyframes spin {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="loading-container">
                            <div class="loading-spinner"></div>
                            <div class="loading-text">Welcome!'.$user['fname'].'.</div>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "'.$employeeLocation.'";
                            }, 2000); // Redirect after 3 seconds
                        </script>
                    </body>
                </html>';
            exit;
        }
    } else {
        echo "Invalid username or password. Please try again.";
    }
} else {
    echo "Form not submitted.";
}