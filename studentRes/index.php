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
    <link rel="stylesheet" type="text/css" href="styles/schedule.css">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
</head>
<title>Home</title>

<body>
    <?php include 'php/header.php'; ?>

    <div class='content'>
        <h2>Welcome to the Student Resources homepage!</h2>

        <p>As an administrator to the site, you will have access to
            view all the current records in the database, add records,
            update users, and search any specific records.</p>

        <br />
        <h3> Home</h3>
        <p>Is where the heart is</p>
        <br />

        <h3>Student Dashboard</h3>
        <p>From student dashboard, a sudent can
            log in to their account on this page. From here, a student
            can view, modify, and delete their profile. They can also
            view the estimated number of hours that they have left to
            complete outstanding tasks. A student's schedule, active
            task lists, and courses can also be viewed. </p>

        <h3>Administration </h3>
        <p> All records from
            any table in the database can be viewed here. Each column of
            the displayed table can be sorted on, in ascending order, by clicking on the column title.
        </p>
        <br/>

        <h3> Add Record </h3>
        <p> A record can be added to any table here. </p>
        <br/>

        <h3> Edit a record</h3>
        <p> After searching for a task by task ID, the found task can be updated and/or deleted.

    </div>
</body>

</html>