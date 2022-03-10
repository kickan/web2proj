<?php
$pagename = "Admin Skills";
$bodyId = "adminskills";

include_once("includes/config.php");


include("includes/header.php");

#Create new user obj
$user = new User;

#Check if user is logged in
if (!$user->isLoggedIn()) {
    header("Location:login.php?error=1");
}

$message = "";

#create new skills obj
$skills = new Skills;



#Check if about me is saved and should be updated
if (isset($_POST["about-btn"])) {
    $slogan = $_POST["slogan"];
    $content = $_POST["content"];

    if ($skills->updateAboutMe($slogan, $content, "")) {
        $message = "Om mig har uppdaterats!";
    } else {
        $message = "Något gick fel då informationen skulle sparas!";
    }
}

#Check if new experience is added
if (isset($_POST["exp-btn"])) {
    $title = $_POST["title"];
    $location = $_POST["location"];
    $sdate = $_POST["startdate"];
    $edate = $_POST["enddate"];
    $content = $_POST["content"];
    $type = $_POST["type"];

    if ($skills->createExp($title, $location, $sdate, $edate, $content, $type)) {
        $message = "Erfarenheten har lagts till!";
    } else {
        $message = "Något gick fel när erfarenheten skulle sparas!";
    }
}

#Check if new language is added
if (isset($_POST["lan-Btn"])) {
    $name = $_POST["name"];
    $level = $_POST["level"];
    $type = $_POST["type"];

    if ($skills->createLan($name, $level, $type)) {
        $message = "Språket har lagts till!";
    } else {
        $message = "Något gick fel då språket skulle läggas till";
    }
}

#Get about me information
$about = $skills->getAboutMe();
$about = $about[0];

?>
<main>
    <h1 class="center-heading">Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section class="center-box">
        <h2>Om mig</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="slogan">Slogan: </label>
            <input type="text" id="slogan" name="slogan" value="<?= $about["slogan"] ?>">
            <label for="content">Beskrivning: </label><br>
            <textarea name="content" id="content" cols="30" rows="10" style="resize: vertical"><?= $about["content"] ?></textarea><br>
            <input type="submit" id="about-btn" name="about-btn" value="Spara" class="btn btn--green">
            <div id="message-box"></div>
        </form>
    </section>
    <section class="center-box">
        <h2>Erfarenheter</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="type">Typ av erfarenhet: </label><br>
            <select name="type" id="type">
                <option value="utbildning">Utbildning</option>
                <option value="arbete">Arbete</option>
            </select><br>
            <label for="title">Titel/Utbildning: </label>
            <input type="text" id="title" name="title">
            <label for="location">Företag/skola: </label>
            <input type="text" id="location" name="location">
            <label for="startDate">Startdatum: </label>
            <input type="date" name="startdate" id="startdate">
            <label for="enddate">Slutdatum: </label>
            <input type="date" name="enddate" id="enddate">
            <label for="exp-content">Beskrivning: </label><br>
            <textarea name="content" id="exp-content" cols="30" rows="10" style="resize: vertical"></textarea><br>
            <input type="submit" id="exp-Btn" name="exp-btn" value="Spara" class="btn btn--green">
            <div id="message-box"></div>
        </form>
    </section>
    <section>
        <h2 class="center-heading">Sparade erfarenheter</h2>
        <section id="web-container">
        </section>
    </section>
    <section class="center-box">
        <h2>Språk</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="type">Färg: </label><br>
            <select name="type" id="lan-type">
                <option value="yellow">Gul</option>
                <option value="green">Grön</option>
            </select><br>
            <label for="name">Namn: </label>
            <input type="text" id="name" name="name">
            <label for="level">Nivå [%]: </label>
            <input type="number" id="level" name="level">
            <input type="submit" id="lan-Btn" name="lan-Btn" value="Spara" class="btn btn--green">
            <div id="message-box"></div>
            <p><?= $message ?></p>
        </form>
    </section>
    <h2 class="center-heading">Sparade Språk</h2>
        <section id="web-container">
        </section>
</main>
<?php
include("includes/footer.php");
?>