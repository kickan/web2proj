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
    <nav class="admin-nav">
        <li><a href="admin.php">Portfolio</a></li>
        <li><a href="adminskills.php">Skills</a></li>
        <li><a href="adminblog.php">Blogg</a></li>
        <li><a href="adminuser.php">User</a></li>
    </nav>

</main>
<?php
include("includes/footer.php");
?>