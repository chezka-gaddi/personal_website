<?php
    session_start();

    require_once('php/login.php');
    require_once('php/schedule.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $name = 'User Dashboard';
    $schedule = '';
    $courses = '';
    $taskLists = '';
    if(isset($_POST['login'])) {
        if ($name = login()) {
            hideLogin();
            $widgets = getWidgets();
            $schedule = "<h2 class='clickable-heading'>Upcoming Events</h2>" . $widgets['Schedule'];
            $courses = "<h2 class='clickable-heading'>Courses</h2>" . $widgets['Courses'];
            $taskLists = "<h2 class='clickable-heading'>Task Lists</h2>" . $widgets['TaskLists'];
        } else {
            $name = 'Invalid student ID/password.';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <link rel="stylesheet" type="text/css" href="styles/schedule.css">
    <script type="text/javascript" src="js/toggleView.js"></script>
</head>

<body>
<header>
    Student Resources
</header>

<div id='navigation'>
    <a href='index.php' id='home'>Home<i class='fa fa-home'></i></a>
    <a href='dashboard.php' id='dashboard'>Dashboard<i class='fa fa-user'></i></a>
    <a href='display.php' id='display'>Administration<i class='fa fa-database'></i></a>
    <a href='update.php' id='edit'>Edit<i class='fa fa-edit'></i></a>
    <a href='search.php' id='search'>Search<i class='fa fa-search'></i></a>
</div>

<div class="content">
<div id='login' class="widget">
    Login to Access Dashboard: &emsp;
    <form id='loginForm' method='post'>
        Student ID:
        <input type='number' name='studentID' required>
        Password:
        <input type='password' name='passwrd' required>
        <input type='submit' name='login' value='Login' class='button'>
    </form>
</div>

    <?php

    function hideLogin()
    {
    echo "<script>
        document.getElementById('login').display = 'none';
    </script>";
    }
    ?>


    <div id='welcome' class="widget">
    <h2><?php echo $name; ?></h2>
</div>

<div class="widget">
    <?php echo $courses; ?>
</div>

<div id="taskListDisplay" class="widget">
    <?php echo $taskLists; ?>
</div>

<div class="widget">
    <?php echo $schedule; ?>
</div>

</div>

</body>

</html>