<?php
    session_start();

    require_once('php/login.php');
    require_once('php/widgets.php');
    require_once('php/queries.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(isset($_POST['loginBtn'])) {
        $_SESSION['studentID'] = $_POST['studentID'];
        $_SESSION['passwrd'] = $_POST['passwrd'];
        if ($_SESSION['profile'] = login()) {
            $widgets = getWidgets();
            $_SESSION['schedule'] = "<h2 class='clickable-heading'>Schedule</h2>" . $widgets['Schedule'];
            $_SESSION['courses'] = "<h2 class='clickable-heading'>Courses</h2>" . $widgets['Courses'];
            $_SESSION['taskLists'] = "<h2 class='clickable-heading'>Task Lists</h2>" . $widgets['TaskLists'];
            $_SESSION['estTime'] = $widgets['estTime'];
        } else {
            $_SESSION['profile'] = 'Invalid student ID/password.';
        }
    } 
    
    else if(isset($_POST['scheduleBtn'])) {
        $widgets = getWidgets();
        $_SESSION['schedule'] = "<h2 class='clickable-heading'>Schedule</h2>" . $widgets['Schedule'];
    } 
    
    else if(isset($_POST['modify'])) {
        $_SESSION['passwrd'] = $_POST['passwrd'];
        modifyUser();
        $_SESSION['profile'] = login();
    } 
    
    else if(isset($_POST['delete'])) {
        deleteUser();
    } 
    
    else if (isset($_POST['checkTask'])) {
        markCompleted();
        $widgets = getWidgets();
        $_SESSION['taskLists'] = "<h2 class='clickable-heading'>Task Lists</h2>" . $widgets['TaskLists'];
    } 
    
    else {
        unset($_SESSION['studentID']);
        unset($_SESSION['passwrd']);
        unset($_SESSION['schedule']);
        unset($_SESSION['courses']);
        unset($_SESSION['taskLists']);
        unset($_SESSION['estTime']);
        $_SESSION['profile'] = 'User Dashboard';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles/header.css">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <link rel="stylesheet" type="text/css" href="styles/layout.css">
    <link rel="stylesheet" type="text/css" href="styles/smallTables.css">
    <script type="text/javascript" src="js/toggleView.js"></script>
</head>

<body>
<?php include 'php/header.php'; ?>

<div class="content">
    <div id='login' class="widget">
        Login to Access Dashboard: &emsp;
        <form id='loginForm' method='post'>
            Student ID:
            <input type='number' name='studentID' required>
            Password:
            <input type='password' name='passwrd' required>
            <input type='submit' name='loginBtn' value='Login' class='button'>
        </form>
    </div>

    <div class='widgetBox2'>

        <div class='widgetBox1'>
            <div id='welcome' class="widget">
                <h2>
                    <?php
                    if(isset($_SESSION['profile'])) {
                        echo $_SESSION['profile'];
                    }
                    ?>
                </h2>
            </div>

            <div id="estTime" class="widget">
                <?php
                if(isset($_SESSION['estTime'])) {
                    echo $_SESSION['estTime'];
                }
                ?>
            </div>
        </div>

        <div id='scheduleWidget' class="widget">
            <?php
            if(isset($_SESSION['schedule'])) {
                echo $_SESSION['schedule'];
            }
            ?>
        </div>

        <div class="widget">
            <?php
            if(isset($_SESSION['courses'])) {
                echo $_SESSION['courses'];
            }
            ?>
        </div>

    </div>

    <div id="taskListDisplay" class="widget">
        <?php
        if(isset($_SESSION['taskLists'])) {
            echo $_SESSION['taskLists'];
        }
        ?>
    </div>


</div>

</body>

</html>