<?php
$pagename = "Blogg";
$bodyId = "blog";
include("includes/header.php");

#create new post obj
$post = new Post;

#get list of websites
$postLst = $post->getPosts();


?>
<main>
    <h1 class="header-center">Blogg</h1>
        <section class="full card__container" id="post-container"><!--Posts are printed with JS and DOM-manipulation-->
    </section>

</main>
<?php
include("includes/footer.php");
?>