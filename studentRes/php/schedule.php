<?php
/**
 * Created by PhpStorm.
 * User: 7180120
 * Date: 4/3/2019
 * Time: 7:09 AM
 */

    function getWidgets() {
        $widgets = array();
        $widgets['Schedule'] = getSchedule();
        $widgets['Courses'] = getCourses();
        $widgets['TaskLists'] = getTaskLists();
        return $widgets;
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

        $stmt = $mysqli->prepare("SELECT activityName, startTime, endTime FROM Activity WHERE User_studentID=? ORDER BY startTime");
        $stmt->bind_param("i", $studentID);
        $studentID = $_POST['studentID'];
        $stmt->execute();
        $stmt->bind_result($bind_activityName, $bind_startTime, $bind_endTime);

        $schedule = '<span><table>';
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
        $studentID = $_POST['studentID'];
        $stmt->execute();
        $stmt->bind_result($bind_courseID, $bind_courseName, $bind_creditHours);
        $courseList = '<span><table>';
        while ($stmt->fetch()) {
            $courseList .= '<tr>';
            $courseList .= '<td>' . $bind_courseID . '</td>';
            $courseList .= '<td>' . $bind_courseName . '</td>';
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

    $stmt = $mysqli->prepare("SELECT taskListName FROM TaskList RIGHT JOIN Project on taskListID=TaskList_taskListID WHERE User_studentID=?");
    $stmt->bind_param("i", $studentID);
    $studentID = $_POST['studentID'];
    $stmt->execute();
    $stmt->bind_result($bind_taskListName);
    $taskList = '<span><table>';
    while ($stmt->fetch()) {
        $taskList .= '<tr>';
        $taskList .= '<td>' . $bind_taskListName . '</td>';
        $taskList .= '</tr>';
    }
    $taskList .= '</table></span>';
    $mysqli->close();
    $stmt->close();
    return $taskList;
}