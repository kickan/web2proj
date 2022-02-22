<?php
$pagename = "Startsida";
include("includes/header.php");

#create new post obj
$post = new Post;

#Get 3 latest posts
$latestPosts = $post->getPosts(3);
?>
<main>
    <h1>Admin</h1>

</main>
<?php
include("includes/footer.php");
?>