<?php
$pagename = "Redigera Blogg";
$bodyId = "editweb";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

#create new post obj
$web = new Website;

$f_id = "";
$f_title = "";
$f_content = "";
$f_link ="";

$message = "";

#check for post to edit
if (isset($_GET["edit"])) {
    $f_id = $_GET["edit"];
    $webInfo = $web->getWebsite($_GET["edit"]);

    $f_title = $webInfo[0]["title"];
    $f_content = $webInfo[0]["content"];
    $f_link = $webInfo[0]["link"];
}

#Check if post is saved
if (isset($_POST["editWebBtn"])) {
    $title = $_POST["title"];
    $id = $_POST["id"];
    $content = $_POST["content"];
    $link = $_POST["link"];

    #Save input in form
    $f_id = $id;
    $f_title = $title;
    $f_content = $content;
    $f_link = $link;

    #Check if all fields are filled in
    if ($title != "" && $content != "" && $link != "") {
        if ($web->updateWebsite($id, $title, $content, $link)) {
            $message = "Webbsidan har uppdaterats";
            #Empty form
            $f_id = "";
            $f_title = "";
            $f_content = "";
            $f_link = "";
        } else {
            $message = "Något gick fel då webbsidan skulle sparas!";
        }
    } else {
        $message = "Webbsidan måste ha en titel, beskrivning och länk";
    }
}

?>
<main>
    <h1 class="center-heading">Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section class="center-box">
        <h2 class="center-header">Redigera webbsida</h2>
        <form action="edit.php" method="POST" class="form form--green">
            <input type="hidden" name="id" value="<?= $f_id ?>">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title" value="<?= $f_title ?>"><br>
            <label for="link">Länk till webbplats: </label>
            <input type="url" name="link" id="link" value="<?= $f_link ?>">
            <label for="content">Innehåll: </label><br>
            <textarea name="content" id="content" cols="30" rows="10" style="resize: vertical"><?= $f_content?></textarea><br>
            <p id="message-box"><?= $message ?></p>
            <input type="submit" class="btn btn--green" name="editWebBtn" value="Spara ändringar">
        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>