<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

#List pages
$pages = array(
    "Portfolio" => "admin.php",
    "Skills" => "adminskills.php",
    "Blogg" => "adminblog.php",
    "Användare" => "adminuser.php"
)
?>
<nav>
    <ul class="admin-nav nav-lst">
        <?php
        #print pages
        $current = basename($_SERVER["SCRIPT_FILENAME"]);
        foreach ($pages as $page => $pageFileName) {
            if ($current == $pageFileName) {
        ?>
                <li class="admin-nav-li--active"><a href="<?= $pageFileName ?>"><?= $page ?></a></li><?php
                                                                                                    } else { ?>
                <li><a href="<?= $pageFileName ?>"><?= $page ?></a></li><?php
                                                                                                    }
                                                                                                } ?>
    </ul>
</nav>