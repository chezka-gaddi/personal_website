<?php
    session_start();

    require_once 'queries.php';

    $table = '';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(isset($_POST['db_tables'])) {
        $_SESSION['display'] = $_POST['db_tables'];
        $table = displayTable();
    }

    if(isset($_GET['orderBy'])) {
        $table = displayTable();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Display</title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
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
    ?>

    <body>
        <div class='content'>
            <h2>Display Data in Student Resource Database</h2>
            <hr />
            <br />

            <form method='post'>
            Choose the data you would like to display:
            <select id='db_tables' name='db_tables'>
            <?php
                $num = $result->num_rows;
                for ($i = 0; $i < $num; $i++)
                {
                	$row=$result->fetch_row();
                   	echo "<option> $row[0] </option>";
                }
            ?>
            </select>
            <input type="submit" value="Get Records" class="button">
            </form>

            <br />
            <?php
                echo $table;
            ?>
        </div>

    </body>
</html>