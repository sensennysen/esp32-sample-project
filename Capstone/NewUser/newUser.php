<?php

require 'vendor/autoload.php';
require_once('dbNewUser.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

 $addNewUser = new AddNewUser();

 $profileImageName = $_FILES['uploadImage']['name'];
 $profileImageTmp = $_FILES['uploadImage']['tmp_name'];

 $uploadPath = 'uploads/' . $profileImageName;
 move_uploaded_file($profileImageTmp, $uploadPath);

    $formData = [
        'upload_Image' => $uploadPath, 
        'department' => $_POST['department'],
        'fUrl' => $_POST['fUrl'],
        'email' => $_POST['email'],
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'], 
        'MiddleInitial' => $_POST['MiddleInitial'],
        'Suffix' => $_POST['Suffix'],
        'gender' => $_POST['gender'],
        'MobNo' => $_POST['MobNo'], 
        'AltCon' => $_POST['AltCon'],
        'birthDate' => $_POST['birthDate'],
        'StreetAdd' => $_POST['StreetAdd'],
        'city' => $_POST['city'],
        'country' => $_POST['country'],
        'pno' => $_POST['pno'],
        'province' => $_POST['province'],
        'uname' => $_POST['uname'],
        'password' => $_POST['password']
    ];

    // var_dump($formData);
    // die();

    $addNewUser = new AddNewUser();

    // Insert the new user
    $result = $addNewUser->insertUser($formData);

    echo $result;
} else {
    echo "Invalid request method.";
}
