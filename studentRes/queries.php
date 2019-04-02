<?php
    function displayTable() {
        if(isset($_POST['db_tables'])) {
            $table = $_POST['db_tables'];
        } else {
            $table = $_SESSION['display'];
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
        $query = "SELECT * FROM " . $table;
        if(isset($_GET['orderBy'])) {
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

        $_SESSION['display'] = $table;

       return $html;
    }
?>