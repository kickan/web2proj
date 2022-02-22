<?php
$pagename = "Startsida";
include("includes/header.php");

#create new post obj
$post = new Post;

#Get 3 latest posts
$latestPosts = $post->getPosts(3);
?>
<main>
    <h1>Kristina Abrahamsson</h1>
    <?php
    #list latest posts
    foreach ($latestPosts as $p) {
    ?>
        <article>
            <h2><?= $p['title'] ?></h2>
            <p><?= $p['created'] ?></p>
            <p><?= $p['description'] ?></p>
            <a href="single.php?id=" <?= $p['id'] ?>>läs mer</a>
        </article><?php
                }
                    ?>
</main>
<?php
include("includes/footer.php");
?>