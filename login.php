<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

$pagename = "Logga in";
$bodyId = "login";
include("includes/header.php");

#Create new user obj
$user = new User;
$message = "";
$f_username = "";

#Check for error message
if (isset($_GET['error'])) {
    if ($_GET['error'] == '1') {
        $message = "Du måste vara inloggad för att besöka denna sida.";
    }
}

#Check if user wants to login
if (isset($_POST['logInBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->loginUser($username, $password)) {
        $_SESSION['k_user'] = $username;
        header("Location:admin.php");
    } else {
        $f_username = $username;
        $message = "Felaktigt användarnamn eller lösenord!";
    }
}
?>

<main>
    <h1 class="header-center">Logga in</h1>
    <section class="card card-login">
    <form action="login.php" method="post" class="form form--green">
        <label for="username">Användarnamn: </label><br>
        <input type="text" id="username" name="username" value="<?= $f_username ?>"><br>
        <label for="password">Lösenord: </label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" name="logInBtn" value="Logga in" class="btn btn--green">
        <p class="error"><?= $message ?></p>
    </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>