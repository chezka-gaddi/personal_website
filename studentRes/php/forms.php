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
                /* Create password input */
                if (strpos($field->name, 'passwrd') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='password' id='$field->name' name='$field->name'>";
                }
                
                /* Input type datetime */
                else if (strpos($field->name, 'Time') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='datetime-local' id='$field->name' name='$field->name' value='2019-01-01T12:00:00.0'>";
                }
                
                /* Input type date */
                else if (strpos($field->name, 'DOB') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='date' id='$field->name' name='$field->name' value='2019-01-01'>";
                }
                
                /* Don't allow input of generated IDs */
                else if (strpos($field->name, 'ID') !== false and (strpos($field->name, 'student') === false) and strpos($field->name, 'course') === false) {
                    continue;
                }
                
                /* Input type number */
                else if (strpos($field->name, 'GPA') !== false or strpos($field->name, 'estDuration') !== false or strpos($field->name, 'creditHours') !== false) {
                    $html .= $field->name . ': ';
                    $html .= "<input type='number' id='$field->name' name='$field->name'> <br />";
                }

                /* Input type range */
                else if ($field->name === 'priority') {
                    $html .= $field->name . ': ';
                    $html .= "<input type='range' min='1' max='3' id='$field->name' name='$field->name' value='1' list='priorities'>
                    <output for='$field->name'>level</output>
                    <datalist id='priorities'>
                        <option value='1' label='low' />
                        <option value='2' label='moderate' />
                        <option value='3' label='high' />
                    </datalist>
                    <br />";
                }

                else if ($field->name === 'category') {
                    $html .= $field->name . ': ';
                    $html .= "<select id='$field->name' name='$field->name' list='categories'>
                    <datalist id='categories'>
                        <option value='School'>School</option>
                        <option value='Work'>Work</option>
                        <option value='Misc' label='Misc'></option>
                        <option value='Extracurricular'>Extracurricular</option>
                        </datalist>
                        <br />";
                }

                else {
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