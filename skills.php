<?php
$pagename = "Skills";
$bodyId = "skills";
include("includes/header.php");

#create new skills obj
$skills = new Skills;

#Get about me information
$about = $skills->getAboutMe();
$about = $about[0];

#Get Education experience
$education = $skills->getExp("utbildning");
$work = $skills->getExp("arbete");

#Get languauges
$lan = $skills->getLan();


?>
<main>
    <section class="text-box text-box--center">
        <h1 class="header-center">Om mig</h1>
        <p class="text--grey"><?= $about["content"] ?></p>
    </section>
    <section class="text-box--split text-box--yellow">
        <section class="text-box text-box--center">
            <h2>Utbildning</h2>
            <?php
            foreach ($education as $ed) {
            ?>
                <p class="text--bold title"><?= $ed["title"] ?></p>
                <p><?= $ed["location"] ?></p>
                <p><?= $ed["startDate"] . " - " . $ed["endDate"] ?> </p>
                <p><?= $ed["content"] ?></p>
            <?php
            }
            ?>
        </section>
        <section class="text-box">
            <h2>Arbetlivserfarenhet</h2>
            <?php
            foreach ($work as $w) {
            ?>
                <p class="text--bold title"><?= $w["title"] ?></p>
                <p><?= $w["location"] ?></p>
                <p><?= $w["startDate"] . " - " . $w["endDate"] ?> </p>
                <p><?= $w["content"] ?></p>
            <?php
            }
            ?>
        </section>
    </section>
    <section class="text-box text-box--center">
        <h2>Språk</h2>
        <?php
        foreach ($lan as $l) {
        ?>
            <p><?= $l["name"] ?></p>
            <div class="lan-box lan-box--<?= $l["type"] ?>">
                <div class="lan-fill lan-fill--<?= $l["type"] ?>" style="width: <?= $l["level"] ?>%"></div>
            </div><?php
                }
                    ?>
    </section>
</main>
<?php
include("includes/footer.php");
?>