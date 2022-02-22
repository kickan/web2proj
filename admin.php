<?php
$pagename = "Startsida";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if(!$user->isLoggedIn()){
    header("Location:login.php?error=1");
}

#create new post obj
$post = new Post;

#Get 3 latest posts
$latestPosts = $post->getPosts(3);
?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>

</main>
<?php
include("includes/footer.php");
?>