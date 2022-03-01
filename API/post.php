<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#create new post obj
$postapi = new Post;

#Check for added post
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $error = 0;
    $mess = "";

    #Check for empty strings
    if ($title == "" || $content == "") {

        #Update error and message
        $error += 1;
        $mess .= "Blogginlägget måste ha en titel och beskrivning. ";
    } else {
        #Add post
        if ($postapi->createPost($title, $content)) {
            $mess = "Blogginlägget har lagts till!";
        } else {
            $error += 1;
            $mess .= "Något gick fel när blogginlägget skulle läggas till. ";
        }
    }
    #Add error and message to response
    $response = array("error" => $error, "message" => $mess);
} else {
    $number = $_GET["number"];
    $response = $postapi->getPosts($number);
}


echo json_encode($response);
