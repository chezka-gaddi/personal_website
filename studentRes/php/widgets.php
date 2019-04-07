<?php
    function getWidgets() {
        $widgets = array();
        $widgets['Schedule'] = getSchedule();
        $widgets['Courses'] = getCourses();
        $widgets['TaskLists'] = getTaskLists();
        $widgets['estTime'] = getEstTime();
        return $widgets;
    }


    function getEstTime() {
        
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


        $stmt = $mysqli->prepare("SELECT SUM(T.estDuration) FROM Task T INNER JOIN TaskList L ON T.TaskList_taskListID=L.taskListID, Project P WHERE P.User_studentID=? AND T.completed=0 AND T.dueDate>current_timestamp()");
        $stmt->bind_param("s", $studentID);
        $studentID = $_SESSION['studentID'];
        $studentID = $mysqli->real_escape_string($studentID);

        $stmt->execute();
        $stmt->bind_result($bind_sumEstDuration);

        $chk = $stmt->fetch();
        $html = "EST (hrs) For Upcoming Tasks: $bind_sumEstDuration";

        return $html;
    }


    function getSchedule() {
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

        if (isset($_POST['scheduleStartTime']) and isset($_POST['scheduleEndTime'])) {
            $start = $_POST['scheduleStartTime'];
            $end = $_POST['scheduleEndTime'];
        } else {
            $start = 0;
            $end = '2999-12-31';
        }

        $stmt = $mysqli->prepare("SELECT activityName, startTime, endTime FROM Activity WHERE User_studentID=? AND startTime > ? AND endTime < ? ORDER BY startTime");
        $stmt->bind_param("iss", $studentID, $start, $end);
        $studentID = $_SESSION['studentID'];
        $stmt->execute();
        $stmt->bind_result($bind_activityName, $bind_startTime, $bind_endTime);

        $schedule = "<span>
        <form method='post'>
            <input type='date' name='scheduleStartTime' >
            <input type = 'date' name = 'scheduleEndTime'>
            <input type='submit' name='scheduleBtn' value='Search' class='button'>
        </form>
        <br />
        <table id='userScheduleTable'>";
        while ($stmt->fetch()) {
            $schedule .= '<tr>';
            $schedule .= '<td>' . $bind_activityName . '</td>';
            $formatted = date('m/d/y g:i A', strtotime($bind_startTime));
            $schedule .= '<td>' . $formatted . '</td>';
            $formatted = date('m/d/y g:i A', strtotime($bind_endTime));

            $schedule .= '<td>' . $formatted . '</td>';
            $schedule .= '</tr>';
        }
        $schedule .= '</table></span>';
        $stmt->close();
        $mysqli->close();
        return $schedule;
    }


    function getCourses() {
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

        $stmt = $mysqli->prepare("SELECT * FROM Course WHERE courseID in (SELECT Course_courseID FROM Enrollment WHERE User_studentID=?)");
        $stmt->bind_param("i", $studentID);
        $studentID = $_SESSION['studentID'];
        $stmt->execute();
        $stmt->bind_result($bind_courseID, $bind_courseName, $bind_instructor, $bind_time, $bind_creditHours);
        $courseList = '<span><table>';
        while ($stmt->fetch()) {
            $courseList .= '<tr>';
            $courseList .= '<td>' . $bind_courseID . '</td>';
            $courseList .= '<td>' . $bind_courseName . '</td>';
            $courseList .= '<td>' . $bind_instructor . '</td>';
            $courseList .= '<td>' . $bind_time . '</td>';
            $courseList .= '<td>' . $bind_creditHours . '</td>';
            $courseList .= '</tr>';
        }
        $courseList .= '</table></span>';
        return $courseList;
    }


    function getTaskLists() {
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

    $stmt = $mysqli->prepare("SELECT taskListID, taskListName FROM TaskList RIGHT JOIN Project on taskListID=TaskList_taskListID WHERE User_studentID=?");
    $stmt->bind_param("i", $studentID);
    $studentID = $_SESSION['studentID'];
    $stmt->execute();
    $stmt->bind_result($bind_taskListID, $bind_taskListName);
    $taskList = "<span><table>";
    while ($stmt->fetch()) {
        $taskList .= "<tr>";
        $taskList .= "<td>$bind_taskListID</td>";
        $taskList .= "<td>$bind_taskListName</td>";
        $taskList .= "</tr>";
    }
    $taskList .= "</table></span>";
    $mysqli->close();
    $stmt->close();
    return $taskList;
}