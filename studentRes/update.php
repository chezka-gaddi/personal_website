<?php
session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('php/queries.php');
    $html='';
    if (isset($_POST['searchTask']))
    {
        $_SESSION['taskID']=$_POST['taskID'];
        $html=searchTasks();
    }

    if (isset($_POST['modifyBtn']))
    {

        $html=modifyTasks();
   
    }

    if (isset($_POST['deleteBtn']))
    {

        $html=deleteTask();
   
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update</title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
        <link rel="stylesheet" type="text/css" href="styles/schedule.css">
        <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    </head>

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
        <?php include 'php/header.php'; ?>
        <div class="content">
            <h2>Modify and Delete Tasks</h2>
            <hr><br>
            <form method='post'>
            Enter taskID:
            <input type='text' name='taskID'>
            <input type='submit' name='searchTask' value='Search Task' class='button'/>
            </form>

            <?php echo $html; ?>
        </div>
    </body>
</html>