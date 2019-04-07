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

            case 'Activity':
                $form .= createActivityForm();
                break;

            case 'Enrollment':
                $form .= createEnrollmentForm();
                break;

            case 'Course':
                $form .= createCourseForm();
                break;
        }
        $form .= "<br/><input type='submit' name='add' action='?add=1' class='button'></form>";
        return $form;
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
                    <td><input type='text' name='studentName' maxlength='45' required></td>
                </tr>
                
                <tr>
                    <th>Password:</th>
                    <td><input type='password' name='passwrd' required></td>
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
                    <th>Task List ID:</th>
                    <td><input type='number' name='taskListID' required></td>
                    <th>Task Name:</th>
                    <td><input type='text' name='taskName' maxlength='100' required></td>
                </tr>
                
                <tr>
                    <th>Category:</th>
                    <td>
                        <select name='category'>
                            <option value='School'>School</option>
                            <option value='Work'>Work</option>
                            <option value='Extracurricular'>Extracurricular</option>
                            <option value='Misc' selected='selected'>Misc</option>
                        </select>
                    </td>
                    <th>Priority:</th>
                    <td>
                        <select name='priority'>
                            <option value='1' selected='selected'>Low</option>
                            <option value='2'>Moderate</option>
                            <option value='3'>High</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>Due Date:</th>
                    <td><input type='datetime-local' name='dueDate'></td>
                    <th>Estimated Duration (hrs):</th>
                    <td><input type='number' name='estDuration' min='0'></td>
                </tr>
            </table><br />";
        return $form;
    }


    function createActivityForm() {
        $form =
            "<h3>Add new Activity</h3>
            <table class='formDisplay'>
            <tr>
                <th>Student ID</th>
                <td><input type='number' name='User_studentID' required></td>
                <th>Activity Name</th>
                <td><input type='text' name='activityName' maxlength='100' required></td>
            </tr>

            <tr>
                <th>Start Time</th>
                <td><input type='datetime-local' name='startDate' required /></td>
                <th>End Time</th>
                <td><input type='datetime-local' name='endDate' required /></td>
            </tr>
            </table>";
        return $form;
    }


    function createEnrollmentForm() {
        $script =
            "<h3>Enroll in a Course</h3>
            <table class='formDisplay'>
            <tr>
                <th>Student ID</th>
                <td><input type='number' id='studentID' required></td>
            </tr>
            
            <tr>
                <th>Course ID</th>
                <td><input type='text' id='courseID' required></td>
            </tr>
            </table>";
        return $script;
    }


    function createCourseForm() {
        $form =
            "<h3>Add New Course</h3>
            <table class='formDisplay'>
            <tr>
            <th>Course ID</th>
            <td><input type='text' name='courseID'</td>
            </tr>
            
            <tr>
            <th>Course Name</th>
            <td><input type='text' name='courseName' required></td>
            </tr>
            
            <tr>
            <th>Credit Hours</th>
            <td><input type='number' name='creditHours' min='0' max='6'></td>
            </tr>
            </table>";
        return $form;
    }
