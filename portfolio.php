<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

$pagename = "Portfolio";
$bodyId = "portfolio";
include("includes/header.php");

#create new web obj
$web = new Website;

#get list of websites
$webLst = $web->getAllWebsites();


?>
<main>
    <h1 class="header-center">Portfolio</h1>
    <?php
    #print all webbsites
    foreach ($webLst as $w) {
    ?>
        <section class="web-container">
            <div class="web-content-container">
                <h2 class="web-title"><?= $w["title"] ?></h2>
                <p class="web-content"><?= $w["content"] ?></p>
                <a href="<?= $w["link"] ?>" class="web-link">Besök webbplatsen</a>
            </div>
            <?php if ($w["img"] != "") {
            ?>
                <img src="img/<?= $w["img"] ?>" class="web-img" alt=""> <?php
                                                                    } ?>
        </section><?php
                }
                    ?>
</main>
<?php
include("includes/footer.php");
?>