<?php
$site_name = "Kristina Abrahamsson";
$divider = " | ";

#Load classes
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php'; //sökväg till mappen för dina klasser
});

#start session
session_start();

$devmode = true; //Set devmode

if($devmode){
    #Activate error handling
    error_reporting(-1);
    ini_set("display_errors", 1);

    #Define DB variables
    define("DBHOST", "localhost");
    define("DBUSER", "moment4");
    define("DBPASS", "mom4");
    define("DBDATABASE", "moment4");
}
