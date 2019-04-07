<?php
/**
 * Created by PhpStorm.
 * User: 7180120
 * Date: 4/3/2019
 * Time: 6:38 AM
 */
    function login() {
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

        $stmt = $mysqli->prepare("SELECT * FROM User WHERE (studentID=? AND passwrd=?)");
        $stmt->bind_param("is", $studentID, $passwrd);
        $studentID = $_SESSION['studentID'];
        $passwrd = $_SESSION['passwrd'];
        $stmt->execute();
        $stmt->bind_result($bind_studentID, $bind_studentName, $bind_passwrd, $bind_DOB, $bind_sex, $bind_major, $bind_GPA);
        $chk = $stmt->fetch();
        if ($chk) {
            $profile = "<h2>Welcome $bind_studentName!</h2>";
            $profile .= "<p>Student ID: $bind_studentID</p>";
            $profile .= "<form method='post'><p>Password: <input name='passwrd' type='password' value='$bind_passwrd'></p>";

            $profile .= "<p>Gender: <input name='sex' type='text' maxlength=1 value='$bind_sex'></p>";
            $profile .= "<p>Birthday: <input name='DOB' type='date' value='$bind_DOB'></p>";
            $profile .= "<p>Major: <input name='major' type='text'  value='$bind_major'></p>";
            $profile .= "<p>GPA: <input name='GPA' type='number' value='$bind_GPA'></p> <br><input type='submit' name='modify' value='Edit Info' class='button'><input type='submit' name='delete' value='Delete User' class='button'></form>";
            return $profile;
        }
        return false;
    }