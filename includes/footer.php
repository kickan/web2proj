<?php
#create new user obj
$user = new User;
?>
<div class="footer-wrapper">
    <footer>
        <p></p>
        <p>Kristina Abrahamsson</p>
        <?php
        #Show log out btn if logged in
        if ($user->isLoggedIn()) {
            echo "<a href='logout.php' class='link'>Logga ut </a>";
        } else {
            echo "</p>";
        }
        ?>

    </footer>
</div>
<script src="js/main.js">
</script>
</body>


</html>