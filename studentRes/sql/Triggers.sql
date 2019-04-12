use db_7180120_s19;

DELIMITER //
CREATE TRIGGER Task_insertTrigger
BEFORE INSERT
ON Task
	FOR EACH ROW 
    BEGIN
		IF NEW.category NOT IN ('Misc', 'School', 'Work', 'Extracurricular') THEN
			SET NEW.category = 'Misc';
        END IF;
        
		IF NEW.priority NOT IN ('Low', 'Moderate', 'High') THEN
			SET NEW.priority = 'Low';
		END IF;
        
        IF NEW.estDuration IS NOT NULL AND NEW.estDuration < 0 THEN
			SET NEW.estDuration = 0;
		END IF;
	END;


DELIMITER //
CREATE TRIGGER User_insertTrigger
BEFORE INSERT
ON User
	FOR EACH ROW
    BEGIN
		IF NEW.studentName REGEXP '[^a-zA-Z -]' THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'Student Name cannot contain special characters or numbers.';
		END IF;
        
        IF NEW.passwrd NOT REGEXP '[0-9]' THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'Password must contain at least one number.';
		END IF;
        
        IF NEW.DOB IS NOT NULL AND NEW.DOB > current_timestamp() THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'DOB must be before current date.';
                
		END IF;
        
        IF NEW.sex NOT IN ('M', 'F') THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'sex must be M or F';
		END IF;
        
        IF NEW.GPA < 0 OR NEW.GPA > 4.0 THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'GPA must be between 0.0 and 4.0';
		END IF;
	END;
    
    
DELIMITER //
CREATE TRIGGER Activity_insertTrigger
BEFORE INSERT
ON Activity
	FOR EACH ROW
    BEGIN
		IF NEW.endTime < NEW.startTime THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'startTime must be before endTime.';
		END IF;
	END;


DELIMITER //
CREATE TRIGGER Course_insertTrigger
BEFORE INSERT
ON Course
	FOR EACH ROW
    BEGIN
		IF NEW.instructor REGEXP '[^a-zA-Z -]' THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'instructor cannot contain special characters or numbers.';
		END IF;
		IF NEW.creditHours < 0 OR NEW.creditHours > 5 THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'creditHours must be between 0 and 5';
		END IF;
	END;




DELIMITER //
CREATE TRIGGER Task_updateTrigger
BEFORE UPDATE
ON Task
	FOR EACH ROW 
    BEGIN
		IF NEW.category NOT IN ('Misc', 'School', 'Work', 'Extracurricular') THEN
			SET NEW.category = 'Misc';
        END IF;
        
		IF NEW.priority NOT IN ('Low', 'Moderate', 'High') THEN
			SET NEW.priority = 'Low';
		END IF;
        
        IF NEW.estDuration IS NOT NULL AND NEW.estDuration < 0  THEN
			SET NEW.estDuration = 0;
		END IF;
	END;


DELIMITER //
CREATE TRIGGER User_updateTrigger
BEFORE UPDATE
ON User
	FOR EACH ROW
    BEGIN
		IF NEW.studentName REGEXP '[^a-zA-Z -]' THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'Student Name cannot contain special characters or numbers.';
		END IF;

        IF NEW.passwrd NOT REGEXP '[0-9]' THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'Password must contain at least one number.';
		END IF;
        
        IF NEW.DOB IS NOT NULL AND NEW.DOB > current_timestamp() THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'DOB must be before current date.';
		END IF;
        
        IF NEW.sex NOT IN ('M', 'F') THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'sex must be M or F';
		END IF;
        
        IF NEW.GPA < 0 OR NEW.GPA > 4.0 THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'GPA must be between 0.0 and 4.0';
		END IF;
	END;
    
    
DELIMITER //
CREATE TRIGGER Activity_updateTrigger
BEFORE UPDATE
ON Activity
	FOR EACH ROW
    BEGIN
		IF NEW.endTime < NEW.startTime THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'startTime must be before endTime.';
		END IF;
	END;


DELIMITER //
CREATE TRIGGER Course_updateTrigger
BEFORE UPDATE
ON Course
	FOR EACH ROW
    BEGIN
		IF NEW.instructor REGEXP '[^a-zA-Z -]' THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'instructor cannot contain special characters or numbers.';
		END IF;
		IF NEW.creditHours < 0 OR NEW.creditHours > 5 THEN
			SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'creditHours must be between 0 and 5';
		END IF;
	END;