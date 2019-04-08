<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'php/forms.php';
    require_once 'php/queries.php';
    require_once 'php/constraints.php';

    $form = '';
    $msg = '';
    if(isset($_POST['db_tables'])) {
        $_SESSION['table'] = $_POST['db_tables'];
        $form = createForm();
        $_SESSION['form'] = $form;
    }

    if(isset($_POST['add'])) {
        $form = $_SESSION['form'];
        $msg = checkConstraints();
        if ($msg == '') {
            $msg = addData();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add</title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
    </head>
    <title>Add</title>

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
            <h2>Add New Record</h2>
            <hr />
            <?php
                echo $msg;
            ?>
            <br />

            <form method='post'>
                Select Type of Data to Add:
                <select id='db_tables' name='db_tables'>
                    <?php
                        $num = $result->num_rows;
                        for ($i = 0; $i < $num; $i++) {
                            $row=$result->fetch_row();
                            echo "<option> $row[0] </option>";
                        }
                    ?>
                </select>
                <input type='submit' value="Fetch Form" class="button">
            </form>
            <br />
            <br />

            <?php
                echo $form;
            ?>
        </div>
    </body>
</html>