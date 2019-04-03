<?php
    function createForm() {
        $table = $_POST['db_tables'];
        $form = "<form method='post'>";
        switch ($table) {
            case 'User':
                $form .= createUserForm();
                break;
            
            case 'Task':
                $form .= createTaskForm();
                break;
        }
        $form .= "<input type='submit' name='add' action='?add=1' class='button'></form>";
        return $form;
    }

    function blach() {
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

    function createUserForm() {
        $form = 
            "<h3>Add New User</h3>
            <table class='formDisplay'>
                <tr>
                    <th>Student ID:</th>
                    <td><input type='number' name='studentID' required></td>
                </tr>
                
                <tr>
                    <th>studentName</th>
                    <td><input type='text' name='studentName' maxlength='45'></td>
                </tr>
                
                <tr>
                    <th>Password:</th>
                    <td><input type='password' name='passwrd'></td>
                </tr>
                
                <tr>
                    <th>Date of Birth:</th>
                    <td><input type='date' name='DOB'></td>
                    <th>GPA:</th>
                    <td><input type='number' name='GPA' min='0' max='4.0' step='0.01'></td>
                </tr>
            </table> <br />";
        return $form;
    }
    
    function createTaskForm() {
        $form = 
            "<h3>Add new Task</h3>
            <table class='formDisplay'>
                <tr>
                    <th>Student ID:</th>
                    <td><input type='number' name='User_studentID'></td>
                    <th>Task List Name:</th>
                    <td><input type='text' name='taskListName'></td>
                </tr>
                
                <tr>
                    <th>Task Name:</th>
                    <td><input type='text' name='taskName'></td>
                </tr>
                
                <tr>
                    <th>Category:</th>
                    <td>
                        <select name='category'>
                        </select>
                    </td>
                    <th>Priority:</th>
                    <td><input type='range' name='priority' min='1' max='3'></td>
                </tr>
                
                <tr>
                    <th>Due Date:</th>
                    <td><input type='date' name='dueDate'></td>
                    <th>Estimated Duration:</th>
                    <td><input type='number' name='estDuration'></td>
                </tr>
            </table> <br />";
        return $form;
    }
?>