<?php
$pagename = "Startsida";
include("includes/header.php");

#create new post obj
$post = new Post;

#Get 3 latest posts
$latestPosts = $post->getPosts(3);
?>
<main>
    <section class="full intro__sec">
        <h1 class="intro__header">Kristina <br> Abrahamsson</h1>
        <img src="img/face1.svg" alt="" class="intro__img">
        <div class="intro__desc">
            <p class="intro__text">Developer, problem solver, </p>
            <p class="intro__text">creative designer</p>
        </div>
    </section>
    <section class="full">
        <?php
        #list latest posts
        foreach ($latestPosts as $p) {
        ?>
            <article>
                <h2><?= $p['title'] ?></h2>
                <p><?= $p['created'] ?></p>
                <p><?= $p['content'] ?></p>
                <a href="single.php?id=" <?= $p['id'] ?>>läs mer</a>
            </article><?php
                    }
                        ?>
    </section>
</main>
<?php
include("includes/footer.php");
?>