<?php
$pagename = "Admin Portfolio";
$bodyId = "admin";

include_once("includes/config.php");


include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}
?>
<main>
    <h1 class="center-heading">Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section class="center-box no-top">
        <h2>Lägg till ny webbplats</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="form form--green">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title"><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> <!-- 200K max storlek -->
            <label for="file">Bild:</label><br>
            <input type="file" name="file" id="file" /><br>
            <label for="link">Länk till webbplats: </label>
            <input type="url" name="link" id="link">
            <label for="content">Beskrivning: </label><br>
            <textarea name="content" id="content" cols="30" rows="10" style="resize: vertical"></textarea><br>
            <input type="submit" id="webBtn" value="Lägg till webbsida" class="btn btn--green">
            <div id="message-box"></div>
        </form>
    </section>
    <section>
        <h2 class="center-heading">Publicerade webbplatser</h2>
        <section id="web-container">
        </section>
    </section>
</main>
<?php
include("includes/footer.php");
?>