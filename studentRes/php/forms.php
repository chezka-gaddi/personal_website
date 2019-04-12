<?php
function createForm() {
    $table = $_POST['db_tables'];
    $form = "<form method='post' class='formDisplay'>";
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

        case 'TaskList':
            $form .= createTaskListForm();
            break;

        case 'Project':
            $form .= createProjectForm();
            break;
    }
    $form .= "<input type='submit' name='add' action='?add=1' class='button'></form>";
    return $form;
}


function createUserForm() {
    $form =
        "<h3>Add New User</h3>
        <table class='formDisplay'>
            <tr>
                <th>Student ID:</th>
                <td><input type='number' name='studentID' required></td>
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
                 <th>Gender:</th>
                <td>
                <select name='sex'>
                    <option>M</option>
                    <option>F</option>
                </select>
                </td>  
                </tr>
                             
                <tr>
                <th>Major:</th>
                <td><input type='text' name='major'></td>
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
                        <option selected='selected'>Low</option>
                        <option>Moderate</option>
                        <option>High</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <th>Due Date:</th>
                <td><input type='datetime-local' name='dueDate'></td>
                <th>Estimated Duration (hrs):</th>
                <td><input type='number' name='estDuration' min='0' max='100'></td>
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
            <td><input type='number' name='studentID' required></td>
        </tr>
        
        <tr>
            <th>Course ID</th>
            <td><input type='text' name='courseID' required></td>
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
        <th>Course Name</th>
        <td><input type='text' name='courseName' required></td>
        </tr>
        
        <tr>
        <th>Instructor</th>
        <td><input type='text' name='instructor'></td>
        <th>Time</th>
        <td><input type='time' name='time'></td>
        </tr>
        
        <tr>
        <th>Credit Hours</th>
        <td><input type='number' name='creditHours' min='0' max='6'></td>
        </tr>
        </table>";
    return $form;
}


function createTaskListForm() {
    $form =
        "<h3>Create New Task List</h3>
            <table class='formDisplay'>
            <tr>
            <th>Task List Name</th>
            <td><input type='text' name='taskListName' required></td>
            </tr>
            </table>";
    return $form;
}


function createProjectForm() {
    $script =
        "<h3>Assign Task List to Student</h3>
            <table class='formDisplay'>
            <tr>
                <th>Student ID</th>
                <td><input type='number' name='studentID' required></td>
            </tr>
            
            <tr>
                <th>Task List ID</th>
                <td><input type='number' name='taskListID' required></td>
            </tr>
            </table>";
    return $script;
}

