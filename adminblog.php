<?php
$pagename = "Admin Blogg";
$bodyId = "adminblog";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}


?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section>
        <h2>Skapa nytt blogginlägg</h2>
        <form action="adminblog.php" method="POST">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title"><br>
            <label for="content">Innehåll: </label><br>
            <textarea name="content" id="content" cols="30" rows="10"></textarea><br>
            <input type="submit" id="addPostBtn" value="Lägg till blogginlägg">
            <p id="message-box"></p>
        </form>
    </section>

    <section>
        <h2>Alla publicerade blogginlägg</h2>
        <div id="post-container">

        </div>
    </section>
</main>
<?php
include("includes/footer.php");
?>