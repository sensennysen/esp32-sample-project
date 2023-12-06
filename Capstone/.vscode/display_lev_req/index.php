<?php
// Include your database connection file
include 'db_conn.php';

// Fetch all records from the leave_application table
$stmt = $pdo->query("SELECT * FROM leave_application");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Leave Applications</title>
</head>
<body>
    <h2>Leave Applications</h2>

    <?php

    // print_r($results);

    if ($results) {
        // Display table header
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Middle Initial</th><th>Email</th><th>Phone Number</th><th>Type of Leave</th><th>Reason</th></tr>";

        // Display records
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>{$row['UserRequestId']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['middle_initial']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone_number']}</td>";
            echo "<td>{$row['leave_type']}</td>";
            echo "<td>{$row['reason']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No leave applications found.";
    }
    ?>

</body>
</html>
