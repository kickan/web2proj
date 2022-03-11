<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#Create new skills obj
$skills = new Skills;

$error = 0;
$mess = "";

#Check if lan is deleted
if (isset($_GET["delete"])) {
    $skills->deleteLan($_GET["delete"]);
    $mess = "Språket har raderats";
} else if (isset($_GET["getSingle"])) { #check if single lan should be returned
    $result = $skills->getSingleLan($_GET["getSingle"]);
} else if (isset($_POST["update"])) { #Check if lan should be updated
    $id = $_POST["update"];
    $name = $_POST["name"];
    $level = $_POST["level"];
    $type = $_POST["type"];
    if ($skills->updateLan($id, $name, $level, $type)) {
        $mess = "Språket har uppdaterats!";
    }
    $result = array('error' => $error, 'message' => $mess);
} else if (isset($_POST["name"])) { #Check if new language is added
    $name = $_POST["name"];
    $level = $_POST["level"];
    $type = $_POST["type"];

    if ($skills->createLan($name, $level, $type)) {
        $mess = "Språket har lagts till!";
    } else {
        $error += 1;
        $mess = "Något gick fel då språket skulle läggas till";
    }
    $result = array('error' => $error, 'message' => $mess);
} else {
    $result = $skills->getLan();
}

echo json_encode($result);
