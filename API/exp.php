<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#Create new skills obj
$skills = new Skills;

$error = 0;
$mess = "";

#Check if exp is deleted
if (isset($_GET["delete"])) {
    $skills->deleteExp($_GET["delete"]);
    $mess = "Erfarenheten har raderats";
} else if (isset($_GET["getSingle"])) { #check if single exp should be returned
    $result = $skills->getSingleExp($_GET["getSingle"]);
} else if (isset($_POST["update"])) { #Check if exp should be updated
    $id = $_POST["update"];
    $title = $_POST["title"];
    $location = $_POST["location"];
    $sDate = $_POST["startDate"];
    $eDate = $_POST["endDate"];
    $content = $_POST["content"];
    $type = $_POST["type"];
    if ($skills->updateExp($id, $title, $location, $sDate, $eDate, $content, $type)) {
        $mess = "Erfarenheten har uppdaterats!";
    }
    $result = array('error' => $error, 'message' => $mess);
} else if (isset($_POST["title"])) { #Check if new experience is added
    $title = $_POST["title"];
    $location = $_POST["location"];
    $sdate = $_POST["startdate"];
    $edate = $_POST["enddate"];
    $content = $_POST["content"];
    $type = $_POST["type"];

    if ($skills->createExp($title, $location, $sdate, $edate, $content, $type)) {
        $mess = "Erfarenheten har lagts till!";
    } else {
        $error += 1;
        $mess = "Något gick fel när erfarenheten skulle sparas!";
    }
    $result = array('error' => $error, 'message' => $mess);
} else {
    $result = $skills->getExp();
}

echo json_encode($result);
