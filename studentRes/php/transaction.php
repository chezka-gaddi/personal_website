<?php
function transaction() {
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                         // default port 3306
    $user = "s7180120_s19";               // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";           // Select DB 

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $mysqli->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    // Maybe automatically add a class to the student's schedule when they enroll
    $stmt = $mysqli->prepare("INSERT INTO Activity (activityName, startTime, endTime, User_studentID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $activityName, $startTime, $endTime, $studentID);

    $stmt2 = $mysqli->prepare("");
    $stmt2->bind_param("i", $var2);

    if (!($stmt->execute() && $stmt2->execute())) {
        $mysqli->rollback();

        $msg = "Transaction aborted.";
    }

    else {
        $mysqli->commit();
        $msg = "Transaction committed.";
    }

    $stmt->close();
    $stmt2->close();
}