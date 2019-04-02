<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'php/forms.php';
    require_once 'php/queries.php';

    $form = '';
    if(isset($_POST['db_tables'])) {
        $_SESSION['table'] = $_POST['db_tables'];
        $form = displayForm();
    }

    if(isset($_POST['add'])) {
        addData();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add</title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
    </head>
    <title>Add</title>

    <?php include 'php/header.php'; ?>

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
        <div class="content">
            <h2>Add New Record</h2>
            <hr />
            <br />

            <form method='post'>
                Select Type of Data to Add:
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
                <input type='submit' value="Add New Record" class="button">
            </form>
            <br />

            <?php
                echo $form;
            ?>
        </div>
    </body>
</html>