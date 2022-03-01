<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#Create new user obj
$user = new User;

#Check if user is added
if (isset($_POST['username'])) {
    #Save data in variables
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

$result = "$name, $username, $pass1, $pass2";
    #Chek if name is ok
    $nameOk = false;
    if ($name != "") {
        $nameOk = true;
    }
    $userOk = false;

    #Check if username is ok
    if ($user->setUsername($username)) {
        #chek if username is occupied
        if (!$user->doUserExist($username)) {
            $userOk = true;
        }
    }

    $passOk = false;

    #Check if password is ok
    if ($pass1 == $pass2) {
        if ($user->setPassword($pass1)) {
            $passOk = true;
        }
    }

    #Add user if all ok
    if ($nameOk && $userOk && $passOk) {
        if ($user->createUser($name, $username, $pass1)) {
            $result = "Användaren är tillagd!";
        }
    }
} else {
    #Get all users
    $result = $user->getAllUsers();
}

echo json_encode($result);
