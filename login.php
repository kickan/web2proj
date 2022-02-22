<?php
$pagename = "Logga in";
include("includes/header.php");

#Create new user obj
$user = new User;
$message = "";

#Check if user wants to login
if(isset($_POST['logInBtn'])){
    $username = $_POST['username'];
    $pass = $_POST['password'];

    if($user->loginUser($username, $password)){
        $_SESSION['k_user'] = $username;
        header("Location:admin.php");
    }else{
        $message = "Felaktigt användarnamn/lösenord!";
    }

}
?>

<main>
    <h1>Logga in</h1>
    <form action="login.php" method="post">
        <label for="username">Användarnamn: </label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Lösenord: </label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" name="logInBtn">
    </form>
</main>
<?php
include("includes/footer.php");
?>