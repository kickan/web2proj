<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

$pagename = "Blogginlägg";
$bodyId = "single";
include("includes/header.php");

#create new post obj
$post = new Post;

#check for post ID
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    #get single post
    $sPost = $post->getSinglePost($id);
    $sPost = $sPost[0];
}

?>
<main>
    <article class="card--big">
        <h1><?= $sPost["title"] ?></h1>
        <p>Publicerad: <?= $sPost["created"] ?></p>
        <?php if ($sPost["img"] != "") {
        ?>
            <img src="img/<?= $sPost["img"] ?>" alt="<?= $sPost["imgtext"] ?>">
        <?php } ?>
        <p><?= $sPost["content"] ?></p>
    </article>
</main>
<?php
include("includes/footer.php");
?>