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

        $stmt = $mysqli->prepare("SELECT studentName, DOB, GPA FROM User WHERE (studentID=? AND passwrd=?)");
        $stmt->bind_param("is", $studentID, $passwrd);
        $studentID = $_POST['studentID'];
        $passwrd = $_POST['passwrd'];
        $stmt->execute();
        $stmt->bind_result($bind_studentName, $bind_DOB, $bind_GPA);
        $chk = $stmt->fetch();
        if ($chk) {
            $profile = "<h2>Welcome $bind_studentName!</h2>";
            $date = date('m/d/y', strtotime($bind_DOB));
            $profile .= "<p>Birthday: $date</p>";
            $profile .= "<p>GPA: $bind_GPA</p>";
            return $profile;
        }
        return false;
    }