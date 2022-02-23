<?php
$pagename = "Admin Användare";
include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

#Variables
$message = "";
$passMess = "";
$userMess = "";
$nameMess = "";
$f_name = "";
$f_username = "";

#Check if user is added
if(isset($_POST['addUserBtn'])){
    #Save data in variables
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    #Save data in form
    $f_name = $name;
    $f_username = $username;

    #Chek if name is ok
    $nameOk = false;
    if($name != ""){
        $nameOk = true;
    }else{
        $nameMess = "Namn måste vara ifyllt";
    }

    $userOk = false;

    #Check if username is ok
    if($user->setUsername($username)){
        #chek if username is occupied
        if(!$user->doUserExist($username)){
            $userOk = true;
        }else{
            $userMess = "Användarnamnet är upptaget, prova ett annat";
        }
    }else{
        $userMess = "Användarnamnet måste vara minst två tecken långt";
    }

    $passOk = false;

    #Check if password is ok
    if($pass1 == $pass2){
        if($user->setPassword($pass1)){
            $passOk = true;
        }else{
            $passMess = "Lösenordet måste vara minst 7 tecken långt och innehålla versaler, gemener och siffror";
        }
    }else{
        $passMess = "Lösenorden stämmer inte överens";
    }

    #Add user if all ok
    if($nameOk && $userOk && $passOk){
        if($user->createUser($name, $username, $pass1)){
            $message = "Användaren är tillagd!";
            header("Location:adminuser.php");
        }else{
            $message .= "Något gick fel när användaren skulle läggas till";
        }
    }
}

#Get all users
$allUsers = $user->getAllUsers();


?>
<main>
    <h1>Admin</h1>
    <?php include("includes/adminnav.php") ?>
    <section>
        <h2>Användare</h2>
        <ul>
            <?php
            #list att users
            foreach ($allUsers as $u) {
            ?>
                <li><?= $u['username'] ?></li>
            <?php
            }
            ?>
        </ul>
    </section>
    <section>
        <h2>Skapa ny användare</h2>
        <form action="adminuser.php" method="POST">
            <label for="name">Namn: </label><br>
            <p><?= $nameMess ?></p>
            <input type="text" id="name" name="name" value="<?= $f_name ?>" required><br>
            <label for="username">Användarnamn: </label><br>
            <p><?= $userMess ?></p>
            <input type="text" id="username" name="username" value="<?= $f_username ?>" required><br>
            <label for="password1">Lösenord: </label><br>
            <p><?= $passMess ?></p>
            <input type="password" id="password1" name="password1" required><br>
            <label for="password2">Upprepa lösenordet: </label><br>
            <input type="password" id="password2" name="password2" required ><br>
            <input type="submit" name="addUserBtn" value="Lägg till användare">
            <p><?= $message ?></p>
        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>