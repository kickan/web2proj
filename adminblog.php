<?php
$pagename = "Admin Blogg";
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

#Create new post obj
$post = new Post;

#Check for added post
if (isset($_POST['addPostBtn'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    #Check for empty strings
    if ($title == "" || $content == "") {
        #Save posted content in form
        $f_title = $title;
        $f_content = $content;

        #Update message
        $message = "Blogginlägget måste ha en titel och beskrivning.";
    } else {
        #Add website
        if ($post->createPost($title, $content)) {
            $message = "Blogginlägget har lagts till!";
        } else {
            $message = "Något gick fel när blogginlägget skulle läggas till";
        }
    }
}

#Get all blogposts
$allPosts = $post->getPosts();

?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section>
        <h2>Skapa nytt blogginlägg</h2>
        <form action="adminblog.php" method="POST">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title" value="<?= $f_title ?>"><br>
            <label for="content">Innehåll: </label><br>
            <textarea name="content" id="content" cols="30" rows="10"><?= $f_content ?></textarea><br>
            <input type="submit" name="addPostBtn" value="Lägg till blogginlägg">
            <p><?= $message ?></p>
        </form>
    </section>

    <section>
        <h2>Alla publicerade blogginlägg</h2>
        <ul>
            <?php
            #list all blog posts
            foreach ($allPosts as $p) {
            ?>
                <li><?= $p['title'] ?></li>
            <?php
            }
            ?>
        </ul>
    </section>
</main>
<?php
include("includes/footer.php");
?>