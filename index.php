<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

$pagename = "Startsida";
$bodyId = "index";
include("includes/header.php");

?>
<main>
    <section class="full intro__sec">
        <h1 class="intro__header">Kristina <br> Abrahamsson</h1>
        <div class="img-container">
            <img src="img/face1.png" alt="" class="intro__img" id="img1">
            <img src="img/face2.png" alt="" class="intro__img" id="img2">
            <img src="img/face3.png" alt="" class="intro__img" id="img3">
        </div>
        <div class="intro__desc">
            <p class="intro__text">Developer, problem solver, </p>
            <p class="intro__text">creative designer</p>
        </div>
    </section>
    <section class="card__container" id="post-container">
        <!--Posts are printed with JS and DOM-manipulation-->
    </section>
</main>
<?php
include("includes/footer.php");
?>