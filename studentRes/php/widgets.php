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

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $stmt = $mysqli->prepare("SELECT SUM(T.estDuration) FROM Task T INNER JOIN TaskList L ON T.TaskList_taskListID=L.taskListID INNER JOIN Project P ON L.taskListID=P.TaskList_taskListID WHERE P.User_studentID=? AND T.completed=0");
    $stmt->bind_param("s", $studentID);
    $studentID = $_SESSION['studentID'];
    $studentID = $mysqli->real_escape_string($studentID);

    $stmt->execute();
    $stmt->bind_result($bind_sumEstDuration);

    $chk = $stmt->fetch();
    $html = "EST to Complete all Unfinished Tasks: $bind_sumEstDuration hrs";

    return $html;
}


function getSchedule() {
    $host="services1.mcs.sdsmt.edu";    // hostname URL
    $port=3306;						    // default port 3306
    $user="s7180120_s19";				// DBMS login username
    $password="wondertwins";			// DBMS login password
    $dbname="db_7180120_s19";		    // Select DB

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

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
    <table>";
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

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

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

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);
    $mysqli2 = new mysqli($host, $user, $password, $dbname, $port);

    if ($mysqli->connect_errno or $mysqli2->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $stmt = $mysqli->prepare("SELECT taskListID, taskListName FROM TaskList RIGHT JOIN Project on taskListID=TaskList_taskListID WHERE User_studentID=?");
    $stmt->bind_param("i", $studentID);
    $studentID = $_SESSION['studentID'];
    $stmt->execute();
    $stmt->bind_result($bind_taskListID, $bind_taskListName);
    $taskList = "<span>";

    while ($stmt->fetch()) {
        $taskList .= "<h4 class='clickable-heading'>$bind_taskListName</h4>";
        $taskList .= "<span><table class='taskListTable'><tr>";
        $task_stmt = $mysqli2->prepare("SELECT taskID, taskName, completed, dueDate, estDuration FROM Task WHERE TaskList_taskListID=? ORDER BY dueDate, priority");
        $task_stmt->bind_param("i", $bind_taskListID);
        $task_stmt->execute();
        $task_stmt->bind_result($bind_taskID, $bind_taskName, $bind_completed, $bind_dueDate, $bind_estDuration);

        while ($task_stmt->fetch()) {

            $dueDate = date("m/d/Y H:i", strtotime($bind_dueDate));
            if ($bind_completed == 1) {
                $taskList .= "<tr>";
                $taskList .= "<td>
                    <form method='post'>
                        <input type='hidden' name='$bind_taskID'>
                        <input type='checkbox' name='checkTask' onChange='this.form.submit()' checked disabled>
                    </form>
                    </td>";

                $taskList .= "<td class='competed'>$bind_taskID</td>";
                $taskList .= "<td class='completed'>$bind_taskName</td>";
                $taskList .= "<td class='completed'>$dueDate</td>";
                $taskList .= "<td class='completed'>$bind_estDuration</td>";
            }

            else {
                if (strtotime($bind_dueDate) < time()) {
                    $taskList .= "<tr class='overdue'>";
                    $taskList .= "<td>
                        <form method='post'>
                            <input type='hidden' name='taskID' value='$bind_taskID'>
                            <input type='checkbox' name='checkTask' onchange='this.form.submit()'>
                        </form>
                        </td>";
                    $taskList .= "<td>$bind_taskID</td>";
                    $taskList .= "<td>$bind_taskName</td>";
                    $taskList .= "<td>$dueDate</td>";
                    $taskList .= "<td>$bind_estDuration</td>";
                }
                else {
                    $taskList .= "<tr>";
                    $taskList .= "<td><input type='checkbox' name='$bind_taskID'></td>";
                    $taskList .= "<td>$bind_taskID</td>";
                    $taskList .= "<td>$bind_taskName</td>";
                    $taskList .= "<td>$dueDate</td>";
                    $taskList .= "<td>$bind_estDuration</td>";
                }
            }

            $taskList .= "</tr>";
        }

        $taskList .= "</table></span><br>";
    }

    $taskList .= "</span>";
    $mysqli->close();
    $stmt->close();
    return $taskList;
}


function markCompleted() {
    $host = "services1.mcs.sdsmt.edu";      // hostname URL
    $port = 3306;                           // default port 3306
    $user = "s7180120_s19";                 // DBMS login username
    $password = "wondertwins";              // DBMS login password
    $dbname = "db_7180120_s19";             // Select DB 

    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    print_r($_POST);

    $stmt = $mysqli->prepare("UPDATE Task SET completed=1 WHERE taskID=?");
    $stmt->bind_param("i", $taskID);
    
    $taskID = $_POST['taskID'];
    $stmt->execute();
    $mysqli->close();
    $stmt->close();
}
