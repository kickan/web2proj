<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#Create new skills obj
$skills = new Skills;

$error = 0;
$mess = "";

#Check if about me is saved and should be updated
if (isset($_POST["slogan"])) {
    $slogan = $_POST["slogan"];
    $content = $_POST["content"];

    if ($skills->updateAboutMe($slogan, $content, "")) {
        $mess = "Om mig har uppdaterats!";
    } else {
        $error += 1;
        $mess = "Något gick fel då informationen skulle sparas!";
    }
    $result = array('error'=> $error, 'message'=> $mess); 
}else{
    $result = $skills->getAboutMe();
}

echo json_encode($result);

