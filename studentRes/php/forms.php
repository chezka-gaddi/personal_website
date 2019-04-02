<?php
    function displayForm() {
        $table = $_POST['db_tables'];
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

        $html = "<form method='post'>";
        if ($result = $mysqli->query($query)) {
            while ($field = $result->fetch_field()) {
                if (strpos($field->name, 'Time') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='datetime-local' id='$field->name' name='$field->name' value='2019-01-01T12:00:00.0'>";
                } else if (strpos($field->name, 'DOB') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='date' id='$field->name' name='$field->name' value='2019-01-01'>";
                } else if (strpos($field->name, 'ID') !== false and strpos($field->name, 'student') === false) {
                    continue;
                } else {
                    $html .= $field->name . ': ';
                    $html .= "<input type='text' id='$field->name' name='$field->name'> <br />";
                }
            }
            $html .= "<input type='submit' name='add' value='Add' class='button' action='?submit=1'>";
        }
        $html .= "</form>";

        return $html;
    }
?>