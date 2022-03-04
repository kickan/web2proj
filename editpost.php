<?php
$pagename = "Edit blogpost";
$bodyId = "edit";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

#create new post obj
$post = new Post;

$f_id = "";
$f_title = "";
$f_content = "";

$message = "";

#check for post to edit
if (isset($_GET["edit"])) {
    $f_id = $_GET["edit"];
    $postInfo = $post->getSinglePost($_GET["edit"]);

    $f_title = $postInfo[0]["title"];
    $f_content = $postInfo[0]["content"];
}

#Check if post is saved
if (isset($_POST["editPostBtn"])) {
    $title = $_POST["title"];
    $id = $_POST["id"];
    $content = $_POST["content"];

    #Save input in form
    $f_id = $id;
    $f_title = $title;
    $f_content = $content;

    if ($title != "" && $content != "") {
        if ($post->updatePost($id, $title, $content)) {
            $message = "Inlägget har uppdaterats";
            #Empty form
            $f_id = "";
            $f_title = "";
            $f_content = "";
        } else {
            $message = "Något gick fel då inlägget skulle sparas!";
        }
    } else {
        $message = "Inlägget måste ha en titel och innehåll";
    }
}

?>
<main>
    <h1 class="center-heading">Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section class="center-box">
        <h2>Redigera blogginlägg</h2>
        <form action="editpost.php" method="POST" enctype="multipart/form-data" class="form form--green">
            <input type="hidden" name="id" value="<?= $f_id ?>">
            <label for="title">Titel: </label><br>
            <input type="text" id="title" name="title" value="<?= $f_title ?>"><br>
            <label for="content">Innehåll: </label><br>
            <textarea name="content" id="content" cols="30" rows="10" style="resize: vertical"><?= $f_content ?></textarea><br>
            <p id="message-box"><?= $message ?></p>
            <input type="submit" class="btn btn--green" name="editPostBtn" value="Spara ändringar">

        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>