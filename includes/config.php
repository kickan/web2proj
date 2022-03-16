<?php
# THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
#-------------------------------------------------------------------------------------------- 

$sitename = "Kristina Abrahamsson";
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

    #Define local DB variables
    define("DBHOST", "localhost");
    define("DBUSER", "web2proj");
    define("DBPASS", "password");
    define("DBDATABASE", "web2proj");
} else{
    #Define public DB variables
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "krab2100");
    define("DBPASS", "PRyWGBRZXR");
    define("DBDATABASE", "krab2100");
}
