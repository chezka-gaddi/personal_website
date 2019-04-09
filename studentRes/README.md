# Student Resource Website

This web service is created to help students manage classes, schedules, and tasks.


## Student Dashboard
This page requires a login specific to a student's account. Once logged in, records relevant to the user is displayed. This includes the student's personal information, schedule, course list, task lists and associated tasks.

<span style="color:green">Query 1:</span> For a student, find activities within a given time span  
```sql
SELECT * FROM Activity WHERE startTime > $start AND endTime < $end
```

<span style="color:green">Query 2:</span> For a given user, display all courses they are enrolled it.  
```sql
SELECT * FROM Course WHERE User_studentID=$studentID
```


<span style="color:green">Query 3:</span> Display the sum total of estimated work hours for a student to complete their unfinished tasks.  
```sql
SELECT SUM(estDuration) FROM Task WHERE
```


## Administration
In the premise of an actual website, access to this page should only happen after a log in. This page displays all of the current records in each other tables.

<table>
    <tr>
        <th>Activity</th>
        <td>Events that would be displayed within a schedule </td>
    </tr>
    <tr>
        <th>Course</th>
        <td>Information about a specific course section</td>
    </tr>
    <tr>
        <th>Enrollment</th>
        <td>Helper table the contains a student and a class they're enrolled in</td>
    </tr>
    <tr>
        <th>Project</th>
        <td>Assignment of a user to a task list</td>
    </tr>
    <tr>
        <th>Task</th>
        <td>Specific chore to be done, contains a due date, category, completion flag</td>
    </tr>
    <tr>
        <th>Task List</th>
        <td>Grouping for tasks with a similar goal</td>
    </tr>
    <tr>
        <th>User</th>
        <td>Contains user information including name, password, gender, birthdate, major, and GPA</td>
    </tr>
</table>


## Add Record
Enables the user to add a record to any of the tables.


## Edit a Task
Allows the user to search for a specific task and edit fields.


## Search
Page made specifically to execute some queries.

<span style="color:green">Query 4:</span> Display the class roster for a given course.  
```sql
SELECT studentID, studentName FROM User, Project WHERE
```

<span style="color:green">Query 5:</span> Display all of the owners of a given task list.

<span style="color:green">Query 6:</span> Search for a particular student's incomplete and overdue tasks.