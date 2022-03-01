<?php
$pagename = "Admin Användare";
$bodyId = "adminuser";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>
    <section>
        <h2>Användare</h2>
        <ul id="user-lst">
        </ul>
    </section>
    <section>
        <h2>Skapa ny användare</h2>
        <form>
            <label for="name">Namn: </label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="username">Användarnamn: </label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password1">Lösenord: </label><br>
            <input type="password" id="password1" name="password1" required><br>
            <label for="password2">Upprepa lösenordet: </label><br>
            <input type="password" id="password2" name="password2" required ><br>
            <input type="submit" value="Lägg till användare" id="addUserBtn">
        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>