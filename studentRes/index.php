<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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
    <title>Home</title>

    <body>
        <?php include 'php/header.php'; ?>

        <div class='content'>
            <h2>Welcome to the Student Resources homepage!</h2>
            
            As an administrator to the site, you will have access to view all the current records in the database, add records, update users, and search any specific records.
        </div>

        <?php include 'php/footer.php'; ?>
    </body>
</html>
