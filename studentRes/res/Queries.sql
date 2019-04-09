use db_7180120_s19;
insert into Task(taskName, category,priority,dueDate,estDuration,TaskList_taskListID) values('Sleepy','Misc',1,'08-24-2019 19:04:43',5.5,6);


# Query to get all Courses of a specific student
/*SELECT *
FROM Course
WHERE courseID in 
(SELECT Course_courseID FROM Enrollment
WHERE User_studentID=7180120);*/

#INSERT INTO Project (User_studentID, TaskList_taskListID) VALUES (1234567, 22);

# Query to get all the Task Lists and associated Tasks
/*CREATE VIEW My_TaskLists
as*/
/*SELECT *
FROM TaskList T RIGHT JOIN  Project P ON T.taskListID=P.TaskList_taskListID
WHERE User_studentID=7180120*/

# Get all Tasks for specific user
/*SELECT *
FROM Task T RIGHT JOIN My_TaskLists L ON T.TaskList_taskListID=L.taskListID
ORDER BY L.taskListID;*/

/*INSERT INTO Project (User_studentID, TaskList_taskListID) VALUES (7180120, 17);
INSERT INTO Project (User_studentID, TaskList_taskListID) VALUES (7180120, 19);
INSERT INTO Project (User_studentID, TaskList_taskListID) VALUES (7180120, 26);*/

#DROP VIEW My_TaskLists;

/*SELECT User_studentID, studentName
FROM Enrollment RIGHT JOIN User on User_studentID=studentID
WHERE Course_courseID='CSC484-M001';*/


/*SELECT DISTINCT T.taskName, T.category, T.priority, T.estDuration, T.dueDate, L.taskListName
FROM Task T INNER JOIN TaskList L on T.TaskList_taskListID=L.taskListID, Project P
WHERE P.User_studentID=7180120 AND T.completed=0 AND T.dueDate < current_timestamp();*/

/*SELECT SUM(estDuration)
FROM Task T INNER JOIN TaskList L on T.TaskList_taskListID=L.taskListID, Project P
WHERE P.User_studentID=7180120 AND T.completed=0 AND T.dueDate > current_timestamp();*/

/*SELECT studentID, studentName
FROM User U JOIN Project P on U.studentID=P.User_studentID
WHERE P.TaskList_taskListID=6;*/

SELECT studentID, studentName
FROM User, Project
WHERE studentID=User_studentID AND TaskList_taskListID=6;
