<?php
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install tables</title>
</head>

<body>
    <?php
    #Connect to database
    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE) or die("DB connection error");

    #Create user table question
    $sql = "DROP TABLE IF EXISTS user;
            CREATE TABLE user(
                id INT(2) PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(128) UNIQUE,
                password VARCHAR(256) NOT NULL,
                name VARCHAR (128),
                created TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";

    #Add user to table
    $password = password_hash("Pass123", PASSWORD_DEFAULT); #hash password
    $sql .= "INSERT INTO user (username, password, name) VALUES
            ('Admin', '$password', 'Administrator');";

    #Create post table
    $sql .= "DROP TABLE IF EXISTS post;
            CREATE TABLE post(
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(128) NOT NULL,
                content TEXT NOT NULL,
                img VARCHAR(128),
                imgtext VARCHAR (256),
                created TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";

    #Create website table question
    $sql .= "DROP TABLE IF EXISTS website;
        CREATE TABLE website(
            id INT(2) PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(128),
            description VARCHAR(256) NOT NULL,
            img VARCHAR (128),
            created TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";

    #Echo query
    echo "<pre>$sql</pre>";

    #Send multiquery to database
    if ($db->multi_query($sql)) {
        echo "INSTALLMENT COMPLETED";
    } else {
        echo "INSTALLMENT ERROR";
    }
    ?>
</body>

</html>