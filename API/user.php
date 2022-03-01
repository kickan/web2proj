<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#Create new user obj
$user = new User;

#Check if user is added
if(isset($_POST['username'])) {
    #Save data in variables
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    $error = 0;
    $mess = "";

    #Chek if name is ok
    $nameOk = false;
    if ($name != "") {
        $nameOk = true;
    } else{
        $error += 1;
        $mess .= "Namnet måste innehålla minst ett tecken. ";
    }
    $userOk = false;

    #Check if username is ok
    if ($user->setUsername($username)) {
        #chek if username is occupied
        if (!$user->doUserExist($username)) {
            $userOk = true;
        }else{
            $error += 1;
            $mess .= "Användarnamnet är upptaget. ";
        }
    }else{
        $error += 1;
        $mess .= "Användarnamnet måste vara minst tre tecken långt. ";
    }

    $passOk = false;

    #Check if password is ok
    if ($pass1 == $pass2) {
        if ($user->setPassword($pass1)) {
            $passOk = true;
        }else{
            $error += 1;
            $mess .= "Lösenordet måste vara minst 7 tecken långt och innehålla versaler, gemener och siffror. ";
        }
    }else{
        $error += 1;
        $mess .= "Lösenorden stämmer inte överens. ";
    }

    #Add user if all ok
    if ($nameOk && $userOk && $passOk) {
        if ($user->createUser($name, $username, $pass1)) {
            $result = array('error'=>0, 'message'=>'Användaren har lagts till!');
        }
    }else{
        $result = array('error'=> $error, 'message'=> $mess); 
    }
} else {
    #Get all users
    $result = $user->getAllUsers();
}

echo json_encode($result);
