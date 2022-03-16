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

#create new skills obj
$skills = new Skills;

?>
<main>
    <h1 class="center-heading">Admin</h1>
    <?php include("includes/adminnav.php") ?>

    <section class="center-box no-top">
        <h2>Om mig</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="slogan">Slogan: </label>
            <input type="text" id="slogan" name="slogan">
            <label for="about-content">Beskrivning: </label><br>
            <textarea name="content" id="about-content" cols="30" rows="10" style="resize: vertical"></textarea><br>
            <input type="submit" id="about-btn" name="about-btn" value="Spara" class="btn btn--green">
            <div id="about-message"></div>
        </form>
    </section>
    <section class="center-box" id="exp-form">
        <h2>Erfarenheter</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="exp-type">Typ av erfarenhet: </label><br>
            <select name="type" id="exp-type">
                <option value="utbildning">Utbildning</option>
                <option value="arbete">Arbete</option>
            </select><br>
            <label for="title">Titel/Utbildning: </label>
            <input type="text" id="title" name="title">
            <label for="location">Företag/skola: </label>
            <input type="text" id="location" name="location">
            <label for="startdate">Startdatum: </label>
            <input type="date" name="startdate" id="startdate">
            <label for="enddate">Slutdatum: </label>
            <input type="date" name="enddate" id="enddate">
            <label for="exp-content">Beskrivning: </label><br>
            <textarea name="content" id="exp-content" cols="30" rows="10" style="resize: vertical"></textarea><br>
            <input type="submit" id="exp-Btn" name="exp-btn" value="Spara" class="btn btn--green">
            <div id="exp-message"></div>
        </form>
    </section>

    <section class="center-box" id="lan-form">
        <h2>Språk</h2>
        <form action="adminskills.php" method="POST" class="form form--green">
            <label for="lan-type">Färg: </label><br>
            <select name="type" id="lan-type">
                <option value="yellow">Gul</option>
                <option value="green">Grön</option>
            </select><br>
            <label for="name">Namn: </label>
            <input type="text" id="name" name="name">
            <label for="level">Nivå [%]: </label>
            <input type="number" id="level" name="level">
            <input type="submit" id="lan-Btn" name="lan-Btn" value="Spara" class="btn btn--green">
            <div id="lan-message"></div>
        </form>

    </section>
    <section>
        <h2 class="center-heading">Sparade erfarenheter</h2>
        <section id="exp-container">
        </section>
    </section>
    <section>
        <h2 class="center-heading">Sparade Språk</h2>
        <section id="lan-container">
        </section>
    </section>
</main>
<?php
include("includes/footer.php");
?>