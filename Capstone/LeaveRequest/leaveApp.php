<?php

require 'vendor/autoload.php';
require_once('leaveDbCon.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'leave_type' => $_POST['leave_type'],
        'reason' => $_POST['reason'],
    ];

    $leaveApplication = new LeaveApplication();

    $result = $leaveApplication->submitLeaveApplication($formData);

    echo $result;
} else {
    echo "Invalid request method.";
}
