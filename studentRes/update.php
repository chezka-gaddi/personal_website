<!DOCTYPE html>
<html>
    <head>
        <title>Update</title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="styles/header.css">
    </head>

    <?php include 'header.php'; ?>


    <?php
        $host="services1.mcs.sdsmt.edu";    // hostname URL
        $port=3306;						    // default port 3306
        $user="s7180120_s19";				// DBMS login username
        $password="wondertwins";			// DBMS login password
        $dbname="db_7180120_s19";		    // Select DB

        /* Connect to MySQL */
        $mysqli = new mysqli($host, $user, $password, $dbname, $port);

        /* Check connection error*/
        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }

        /* Execute Query */
        $result = $mysqli->query("SHOW TABLES");
        $host="services1.mcs.sdsmt.edu";
    ?>

    <body>


    </body>
</html>