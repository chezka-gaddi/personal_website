<?php
    function displayTable() {
        if(isset($_POST['db_tables'])) {
            $table = $_POST['db_tables'];
            $order = false;
        } else {
            $table = $_SESSION['display'];
            $order = $_GET['orderBy'];
        }
        
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

        /* Execute Query */
        $query = 'SELECT * FROM ' . $table;
        if ($order) {
            $query .= ' ORDER BY ' . $_GET['orderBy'];
        }

        $html = "<br/><p>$query</p>";
        $html .= "<p>I promise I made it. I just got lost. Like really lost. </p>
        <table class='tableDisplay'> <tr>";
        if ($result = $mysqli->query($query)) {
            while ($field = $result->fetch_field()) {
                $html .= "<th><a href=?orderBy=$field->name>";
                $html .= "$field->name";
                $html .= "</a></th>";
            }
        }
        $html .= "</tr>";

        if ($result) {
            while ($row = $result->fetch_row()) {
                $html .= "<tr>";
                for ($i = 0; $i < $result->field_count; $i++) {
                    $html .= "<td> $row[$i] </td>";
                }
                $html .= "</tr>";
            }
        }
        $html .= "</table>";

       return $html;
    }

    
    function addData() {
        if(isset($_POST['db_tables'])) {
            $table = $_POST['db_tables'];
        } else {
            $table = $_SESSION['table'];
        }

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

        $msg = '';
        if ($table == 'User') {
            $stmt = $mysqli->prepare("INSERT INTO User (studentID, studentName, passwrd, DOB, GPA) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssd", $studentID, $studentName, $passwrd, $dob, $gpa);
            $studentID = $_POST['studentID'];
            $studentID = $mysqli->real_escape_string($studentID);
            $studentName = $_POST['studentName'];
            $studentName = $mysqli->real_escape_string($studentName);
            $passwrd = $_POST['passwrd'];
            $passwrd = $mysqli->real_escape_string($passwrd);
            $dob = $_POST['DOB'];
            $dob = $mysqli->real_escape_string($dob);
            $gpa = $_POST['GPA'];
            $gpa = doubleval($gpa);
            $msg .= 'inside user';
            if ($stmt->execute()) {
                $msg .= 'Yay!';
            }
        } else if ($table == 'Activity') {
            $stmt = $mysqli->prepare("INSERT INTO Activity (activityName, startTime, endTime, User_studentID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $activityName, $startTime, $endTime, $studentID);
            $activityName = $_POST['activityName'];
            $activityName = $mysqli->real_escape_string($activityName);

            $startTime = date("Y-m-d H:i:s", strtotime($_POST['startTime']));
            $endTime = date("Y-m-d H:i:s", strtotime($_POST['endTime']));

            $studentID = $_POST['User_studentID'];
            $studentID = $mysqli->real_escape_string($studentID);

            $msg .= 'inside activity';
            if ($stmt->execute()) {
                $msg .= 'Yay!';
            }
        }
        return $msg;
    }
?>