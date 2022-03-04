<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#create new post obj
$postapi = new Post;

$error = 0;
$mess = "";

$imgOk = true;



#Check if post is deleted
if (isset($_GET["delete"])) {
    $postapi->deletePost($_GET["delete"]);
    $response = "Inlägget har raderats";
}
#Check for added post
elseif (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imgText = $_POST['imgtext'];

    #Check if file is added
    if (isset($_FILES['file'])) {
        $imgName = $_FILES["file"]["name"];
        //Kontrollerar att uppladdad bild är av rätt typ (JPEG) och att storleken
        //inte överstiger en viss storlek - i det här fallet väldigt stor...
        if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] ==
            "image/pjpeg")) && ($_FILES["file"]["size"] < 200000)) {
            if ($_FILES["file"]["error"] > 0) {
                $error += 1;
                $mess .=  "Felmeddelande: " . $_FILES["file"]["error"] . "<br />";
                $imgOk = false;
            } else {

                //Kontrollerar att en bild med samma namn inte redan finns i 
                //katalogen dit bilden skall flyttas
                if (file_exists("../img/" . $_FILES["file"]["name"])) {
                    $error += 1;
                    $mess .= $_FILES["file"]["name"] . " finns redan. Välj ett annat filnamn.";
                    $imgOk = false;
                } else {

                    //Flyttar filen till rätt katalog      
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../img/" . $_FILES["file"]["name"]);

                    //Spar namn på originalbild och miniatyr i variabler
                    $storedfile = $_FILES["file"]["name"];
                }
            }
        } else {
            // Här hamnar man om det inte är JPEG/bildfil för stor
            $error += 1;
            $mess .= "Ej JPEG/Bildfilen större än 200kb.";
            $imgOk = false;
        }
    } else {
        $imgName = "";
    } // Slut på isset(FILE)

    #Check for empty strings
    if ($title == "" || $content == "") {
        #Update error and message
        $error += 1;
        $mess .= "Blogginlägget måste ha en titel och beskrivning. ";
    } else {
        #check for img error
        if ($imgOk) {
            #Add post
            if ($postapi->createPost($title, $content, $imgName, $imgText)) {
                $mess .= "Blogginlägget har lagts till!";
            } else {
                $error += 1;
                $mess .= "Något gick fel när blogginlägget skulle läggas till. ";
            }
        }
    }
    #Add error and message to response
    $response = array("error" => $error, "message" => $mess);
} elseif(isset($_GET["number"])) {
    $number = $_GET["number"];
    $response = $postapi->getPosts($number);
}


echo json_encode($response);
