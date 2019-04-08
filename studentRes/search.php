<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('php/queries.php');

    $roster = '';
    $owners = '';
    $tasks = '';
    if (isset($_POST['searchCourse']))
    {
        $roster = getClassRoster();
    }

    if (isset($_POST['searchTaskList']))
    {
        $owners = getTaskListOwners();
    }

    if (isset($_POST['searchTasks']))
    {
        $tasks=getMissedTasks();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/layout.css">
    </head>
    <title>Search</title>

    <body>
        <?php include 'php/header.php'; ?>

        <div class="content">
            <h1>FAQ: Frequently Asked Queries</h1>
            <hr>
            <br>
            <div class="widget search">
                <h2>Display Course Roster</h2>
                <hr><br>
            <form method='post'>
            Enter Course ID:
            <input type='text' name='courseID'>
            <input type='submit' name='searchCourse' value='Search' class='button'/>
            </form>

            <?php
                echo $roster;
            ?>
        </div>

            <div class="widget search">
                <h2>Display all Owners of a Given Task List</h2>
                <hr><br>
                <form method='post'>
                    Enter Task List ID:
                    <input type='text' name='taskListID'>
                    <input type='submit' name='searchTaskList' value='View Owners' class='button'/>
                </form>

                <?php
                echo $owners;
                ?>
            </div>

            <div class="widget search">
                <h2>Search for all of a User's incomplete and overdue tasks</h2>
                <hr><br>
                <form method='post'>
                    Enter UserID:
                    <input type='text' name='studentID'>
                    <input type='submit' name='searchTasks' value='Display Tasks' class='button'/>
                </form>

                <?php
                echo $tasks;
                ?>
            </div>
        </div>

    </body>
</html>