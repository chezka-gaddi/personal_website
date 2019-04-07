<?php
function displayTable()
{
    if (isset($_POST['db_tables'])) {
        $table = $_POST['db_tables'];
        $order = false;
    } else {
        $table = $_SESSION['display'];
        $order = $_GET['orderBy'];
    }

    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

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
    $html .= "<table class='tableDisplay'> <tr>";
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


function addData()
{
    if (isset($_POST['db_tables'])) {
        $table = $_POST['db_tables'];
    } else {
        $table = $_SESSION['table'];
    }

    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB

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
        if ($stmt->execute()) {
            $msg .= "<div class='msg green'>
                    Successfully added user!
                    </div>";
        } else {
            $msg = 'Student ID already taken. Was unable to add new user.';
        }
    } else if ($table == 'Activity') {
        $stmt = $mysqli->prepare("INSERT INTO Activity (activityName, startTime, endTime, User_studentID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $activityName, $startDate, $endDate, $studentID);
        $activityName = $_POST['activityName'];
        $activityName = $mysqli->real_escape_string($activityName);

        $startDate = date("Y-m-d H:i:s", strtotime($_POST['startDate']));
        $endDate = date("Y-m-d H:i:s", strtotime($_POST['endDate']));

        $studentID = $_POST['User_studentID'];
        $studentID = $mysqli->real_escape_string($studentID);

        if ($stmt->execute()) {
            $msg .= "<div class='msg green'>
                    Successfully added activity!
                    </div>";
        } else {
            $msg .= 'Oops... something went wrong, unable to add activity';
        }
    } else if ($table == 'Task') {
        $stmt = $mysqli->prepare("INSERT INTO Task (taskName, category, priority, dueDate, estDuration, TaskList_taskListID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdi", $taskName, $category, $priority, $dueDate, $estDuration, $TaskList_taskListID);

        $taskName = $_POST['taskName'];
        $taskName = $mysqli->real_escape_string($taskName);
        $dueDate = date("Y-m-d H:i:s", strtotime($_POST['dueDate']));
        $priority = $_POST['priority'];
        $category = $_POST['category'];
        $category = $mysqli->real_escape_string($category);
        $estDuration = $_POST['estDuration'];
        $TaskList_taskListID = $_POST['taskListID'];

        if ($stmt->execute()) {
            $msg .= "<div class='msg green'>
                    Successfully added task!
                    </div>";
        } else {
            $msg .= 'Oops... something went wrong, unable to add task';
        }
    }

    return $msg;
}


function getClassRoster()
{
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }


    print_r($_POST);
    $stmt = $mysqli->prepare("SELECT User_studentID, studentName FROM User,Enrollment WHERE Course_courseID=? AND User_studentID=studentID");
    $stmt->bind_param("s", $courseID);
    $courseID = $_POST['courseID'];
    $courseID = $mysqli->real_escape_string($courseID);

    $html = "<br/>";
    $html .= "<table class='tableDisplay'> <tr>";
    $html .= "<th> Student ID </th>";
    $html .= "<th> Student Name </th>";
    $stmt->execute();
    $stmt->bind_result($bind_studentID, $bind_studentName);

    while ($chk = $stmt->fetch()) {
        $html .= "<tr>";
        $html .= "<td> $bind_studentID </td>";
        $html .= "<td> $bind_studentName </td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

    return $html;
}


function getMissedTasks()
{
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }


    $stmt = $mysqli->prepare("SELECT DISTINCT T.taskName, T.category, T.priority, T.estDuration, T.dueDate, L.taskListName FROM Task T INNER JOIN TaskList L ON T.TaskList_taskListID=L.taskListID, Project P WHERE P.User_studentID=? AND T.completed=0 AND T.dueDate<current_timestamp()");
    $stmt->bind_param("s", $studentID);
    $studentID = $_POST['studentID'];
    $studentID = $mysqli->real_escape_string($studentID);


    $stmt->execute();
    $stmt->bind_result($bind_taskName, $bind_category, $bind_priority, $bind_estDuration, $bind_dueDate, $bind_taskListName);
    $count = 0;
    $html = "";

    $html = "<br/>";
    $html .= "<table class='tableDisplay'> <tr>";
    $html .= "<th> Task Name </th>";
    $html .= "<th> Category </th>";
    $html .= "<th> Priority </th>";
    $html .= "<th> Est. Duration </th>";
    $html .= "<th> Due Date</th>";
    $html .= "<th> Task List Name </th>";

    while ($chk = $stmt->fetch()) {
        $count++;
        $html .= "<tr>";
        $html .= "<td> $bind_taskName </td>";
        $html .= "<td> $bind_category </td>";
        $html .= "<td> $bind_priority </td>";
        $html .= "<td> $bind_estDuration </td>";
        $html .= "<td> $bind_dueDate </td>";
        $html .= "<td> $bind_taskListName </td>";
        $html .= "</tr>";
    }

    $html .= "</table>";

    if ($count == 0) {
        $html .= "No Results to Display";
    }

    return $html;
}


function getTaskListOwners()
{
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }


    $stmt = $mysqli->prepare("SELECT studentID, studentName FROM User, Project WHERE User.studentID=Project.User_studentID AND Project.TaskList_taskListID=?");
    $stmt->bind_param("i", $taskListID);
    $taskListID = $_POST['taskListID'];

    $html = "<br/>";
    $html .= "<table class='tableDisplay'> <tr>";
    $html .= "<th> Student ID</th>";
    $html .= "<th> Student Name</th>";
    $stmt->execute();
    $stmt->bind_result($bind_studentID, $bind_studentName);

    while ($chk = $stmt->fetch()) {
        $html .= "<tr>";
        $html .= "<td> $bind_studentID </td>";
        $html .= "<td> $bind_studentName </td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

    return $html;
}


function searchTasks()
{
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $count = 0;

    $stmt = $mysqli->prepare("SELECT * FROM Task WHERE TaskID=?");
    $stmt->bind_param("i", $taskID);
    $taskID = $_POST['taskID'];
    $taskID = $mysqli->real_escape_string($taskID);

    $stmt->execute();
    $stmt->bind_result($bind_taskID, $bind_taskName, $bind_category, $bind_priority, $bind_estDuration, $bind_dueDate, $bind_completed, $bind_taskListID);
    
    $html = "<br/>";
    $html .= "<form method='post'>";
    $html .= "<table class='tableDisplay'> <tr>";
    $html .= "<th> Task ID </th>";
    $html .= "<th> Task Name </th>";
    $html .= "<th> Category </th>";
    $html .= "<th> Priority </th>";
    $html .= "<th> Est. Duration </th>";
    $html .= "<th> Due Date</th>";
    $html .= "<th> Completed </th>";
    $html .= "<th> Task List ID</th>";

    while ($chk = $stmt->fetch()) {
        $count++;
        $html .= "<tr>";
        $html .= "<td>$bind_taskID </td>";
        $html .= "<td> <input type='text' name='taskName' value='$bind_taskName'> </td>";
        $html .= "<td> <input type='text' name='category' value='$bind_category'> </td>";
        $html .= "<td> <input type='text' name='priority' value='$bind_priority'> </td>";
        $html .= "<td> <input type='text' name='estDuration' value='$bind_estDuration'> </td>";
        $html .= "<td> <input type='text' name='dueDate' value='$bind_dueDate'> </td>";
        $html .= "<td> <input type='text' name='completed' value='$bind_completed'> </td>";
        $html .= "<td> $bind_taskListID </td>";
        $html .= "</tr>";
    }
    $html .= "</table>
            </br>
            <input type='submit' name='modifyBtn' value='Modify Task' class='button'>
            <input type='submit' name='deleteBtn' value='Delete Task' class='button'>
        </form>";

    if ($count == 0) {
        $html .= "No Results to Display";
    }

    return $html;
}


function modifyTasks(){
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $count = 0;

    $taskName=$_POST['taskName'];
    $category=$_POST['category'];
    $priority=$_POST['priority'];
    $dueDate=$_POST['dueDate'];
    $completed=$_POST['completed'];
    $estDuration=$_POST['estDuration'];

    $stmt = $mysqli->prepare("UPDATE Task SET taskName=?, category=?, priority=?, estDuration=?, completed=? WHERE taskID=?");
    $stmt->bind_param("sssdii", $taskName, $category, $priority, $estDuration, $completed, $taskID );
    $taskID = $_SESSION['taskID'];
    $taskID = $mysqli->real_escape_string($taskID);

    $stmt->execute();
}


function deleteTask()
{
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $stmt = $mysqli->prepare("DELETE FROM Task WHERE taskID=?");
    $stmt->bind_param("s", $taskID );
    $taskID = $_SESSION['taskID'];
    $taskID = $mysqli->real_escape_string($taskID);

    $stmt->execute();
}

function modifyUser() {
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $count = 0;

    $stmt = $mysqli->prepare("UPDATE User SET passwrd=?, sex=?, DOB=?, major=?, GPA=? WHERE studentID=?");
    $stmt->bind_param("ssssdi", $passwrd, $sex, $DOB, $major, $GPA, $studentID);
    $passwrd=$_POST['passwrd'];
    $sex=$_POST['sex'];
    $DOB=$_POST['DOB'];
    $major=$_POST['major'];
    $GPA=$_POST['GPA'];
    $studentID=$_SESSION['studentID'];
    $studentID = $mysqli->real_escape_string($studentID);

    if($stmt->execute())
        echo 'Yay';
        else
        echo 'Boo :,(';
}

function deleteUser(){
    $host = "services1.mcs.sdsmt.edu";    // hostname URL
    $port = 3306;                            // default port 3306
    $user = "s7180120_s19";                // DBMS login username
    $password = "wondertwins";            // DBMS login password
    $dbname = "db_7180120_s19";            // Select DB 

    /* Connect to MySQL */
    $mysqli = new mysqli($host, $user, $password, $dbname, $port);

    /* Check connection error*/
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $stmt = $mysqli->prepare("DELETE FROM User WHERE studentID=?");
    $stmt->bind_param("s", $studentID );
    $studentID = $_SESSION['studentID'];
    $studentID = $mysqli->real_escape_string($studentID);

    $stmt->execute();
}
