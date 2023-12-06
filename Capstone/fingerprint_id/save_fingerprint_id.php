<?php
// FILEPATH: /c:/xampp/htdocs/Capstone/fingerprint_id/save_fingerprint_id.php
include '../dbConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive the fingerprint ID from the ESP32 request
    $fingerprintId = $_POST['fingerprint_id'];

    // Prepare an SQL statement to check for a row with null fingerprint_id in add_new_user table
    $checkStmt = $pdo->prepare("SELECT email FROM add_new_user WHERE fingerprint_id IS NULL LIMIT 1");
    $checkStmt->execute();

    // Check if a row with null fingerprint_id is found
    if ($checkStmt->rowCount() > 0) {
        // Fetch the email from the result
        $row = $checkStmt->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];

        // Update the hashed fingerprint ID using the email in the add_new_user table
        $updateStmt = $pdo->prepare("UPDATE add_new_user SET fingerprint_id = ? WHERE email = ? AND fingerprint_id IS NULL LIMIT 1");
        $updateStmt->bindParam(1, $fingerprintId);
        $updateStmt->bindParam(2, $email);
        $updateStmt->execute();

        // Check if the update was successful
        if ($updateStmt->rowCount() > 0) {
            // Now transfer the row to the employees table
            $transferStmt = $pdo->prepare("INSERT INTO employees 
                (id, upload_Image, department, fUrl, fname, MiddleInitial, lname, gender, birthDate, Suffix, StreetAdd, country, MobNo, AltCon, email, pno, city, province, uname, password, workposition, userRole, regular, fingerprint_id)
                SELECT id, upload_Image, department, fUrl, fname, MiddleInitial, lname, gender, birthDate, Suffix, StreetAdd, country, MobNo, AltCon, email, pno, city, province, uname, password, workposition, userRole, regular, fingerprint_id 
                FROM add_new_user 
                WHERE email = ?");
            $transferStmt->bindParam(1, $email);
            $transferStmt->execute();

            // Check if the transfer was successful
            if ($transferStmt->rowCount() > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Fingerprint ID received, updated, and transferred successfully',
                    'email' => $email,
                    'fingerprint_id' => $fingerprintId
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to transfer row to employees table'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to update fingerprint ID'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No row found with null fingerprint_id in add_new_user table'
        ];
    }

    // Send a response back to the ESP32
    echo json_encode($response);

    // Close the statements
    $checkStmt = null;
    $updateStmt = null;
    $transferStmt = null;
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
