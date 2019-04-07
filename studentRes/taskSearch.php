<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('php/queries.php');
    $html='';
    if (isset($_POST['search']))
    {
        $html=getMissedTasks();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
    </head>
    <title>Manage Tasks</title>

    <body>


        <?php include 'php/header.php'; ?>
        <h2>Search for all of a User's incomplete and overdue tasks.</h2>
        <form method='post'> 
        Enter UserID:
        <input type='text' name='studentID'>
        <input type='submit' name='search' value='Display Tasks' class='button'/>
        </form>

        <?php 
            echo $html;
        ?>

        <?php include 'php/footer.php'; ?>



    </body>
</html>