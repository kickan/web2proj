<?php
$pagename = "Admin";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

#Variables
$message = "";
$f_title = "";
$f_content = "";

#Create new website obj
$website = new Website;

#Check for added webbsite
if (isset($_POST['addWebBtn'])) {
    $title = $_POST['title'];
    $desc = $_POST['content'];
    $img = $_POST['img'];
    
    #Check for empty strings
    if ($title == "" || $desc == "") {
        #Save posted content in form
        $f_title = $title;
        $f_content = $desc;

        #Update message
        $message = "Webbplatsen måste ha en titel och beskrivning.";
    } else {
        #Add website
        if ($website->addWebsite($title, $desc, $img)) {
            $message = "Webbplatsen har lagts till!";
        } else {
            $message = "Något gick fel när webbplatsen skulle läggas till";
        }
    }
}




?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section>
        <h2>Portfolio</h2>
        <form action="admin.php" method="POST">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title" value="<?= $f_title ?>"><br>
            <label for="img">Bild: </label><br>
            <input type="file" name ="img"><br>
            <label for="content">Beskrivning: </label><br>
            <textarea name="content" id="content" cols="30" rows="10"><?= $f_content ?></textarea><br>
            <input type="submit" name="addWebBtn" value="Lägg till webbsida">
            <p><?= $message ?></p>
        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>