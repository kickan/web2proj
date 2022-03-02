<?php
include_once("includes/config.php");

$user = new User;


?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <title><?= $sitename . $divider . $pagename ?></title>
</head>

<body id="<?= $bodyId ?>">
    <div class="header-wrapper">
        <header>
            <p> <a href="index.php">Kristina Abrahamsson</a></p>

            <nav class="glob-nav">
                <ul class="nav-lst glob-nav__lst">
                    <li><a href="portfolio.php">Portfolio</a></li>
                    <li><a href="skills.php">Skills</a></li>
                    <li><a href="blog.php">Blogg</a></li>
                    <?php
                    if ($user->isLoggedIn()) {
                    ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </header>
    </div>