<?php
#create new user obj
$user = new User;
?>
<footer>
<?php 
if($user->isLoggedIn()){
    echo "<a href='logout.php'>Logga ut </a>";
}
?>

</footer>
</body>
<script src="js/main.js"></script>
</html>