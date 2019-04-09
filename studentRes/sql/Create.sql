-- MySQL Workbench Forward Engineering
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_7180120_s19
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_7180120_s19
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_7180120_s19` DEFAULT CHARACTER SET utf8 ;
USE `db_7180120_s19` ;

-- -----------------------------------------------------
-- Table `db_7180120_s19`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`User` (
  `studentID` INT NOT NULL, 
  `studentName` VARCHAR(45) NOT NULL, CHECK (studentName NOT LIKE '%[^a-zA-Z -]%'),
  `passwrd` VARCHAR(45) NOT NULL CHECK (passwrd LIKE '.*[0-9]+.*'),
  `DOB` DATE NULL CHECK (DOB < CURRENT_DATE()),
  `sex` CHAR NULL CHECK (sex in ('M', 'F')),
  `major` VARCHAR(45) NULL CHECK (major NOT LIKE '%[^a-zA-Z -]%'),
  `GPA` DECIMAL(4,2) UNSIGNED NULL CHECK (GPA <= 4.0 & GPA >= 0),
  PRIMARY KEY (`studentID`),
  UNIQUE INDEX `studentID_UNIQUE` (`studentID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`TaskList`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`TaskList` (
  `taskListID` INT NOT NULL AUTO_INCREMENT,
  `taskListName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`taskListID`),
  UNIQUE INDEX `taskListID_UNIQUE` (`taskListID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`Task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`Task` (
  `taskID` INT NOT NULL AUTO_INCREMENT,
  `taskName` VARCHAR(100) NOT NULL,
  `category` VARCHAR(45) DEFAULT 'Misc' CHECK (category in ('School','Extracurricular','Work','Misc')),
  `priority` VARCHAR(45) DEFAULT 'Low' CHECK (priority in ('Low', 'Moderate', 'High')),
  `estDuration` DECIMAL(4,2) NULL,
  `dueDate` DATETIME NULL,
  `completed` BOOLEAN DEFAULT False,
  `TaskList_taskListID` INT NOT NULL,
  PRIMARY KEY (`taskID`),
  INDEX `fk_Task_TaskList1_idx` (`TaskList_taskListID` ASC),
  UNIQUE INDEX `taskID_UNIQUE` (`taskID` ASC),
  CONSTRAINT `fk_Task_TaskList1`
    FOREIGN KEY (`TaskList_taskListID`)
    REFERENCES `db_7180120_s19`.`TaskList` (`taskListID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`Activity`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`Activity` (
  `activityID` INT NOT NULL AUTO_INCREMENT,
  `activityName` VARCHAR(100) NOT NULL,
  `startTime` DATETIME NOT NULL,
  `endTime` DATETIME NOT NULL CHECK (endTime > startTime),
  `User_studentID` INT NOT NULL,
  PRIMARY KEY (`activityID`),
  INDEX `fk_Activity_User1_idx` (`User_studentID` ASC),
  UNIQUE INDEX `activityID_UNIQUE` (`activityID` ASC),
  CONSTRAINT `fk_Activity_User1`
    FOREIGN KEY (`User_studentID`)
    REFERENCES `db_7180120_s19`.`User` (`studentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`Course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`Course` (
  `courseID` VARCHAR(11) NOT NULL CHECK (courseID LIKE '[A-Z]{3}[0-9]{3}-(M)(0){2}[1-9]'),
  `courseName` VARCHAR(45) NOT NULL,
  `instructor` VARCHAR(45) NULL CHECK (instructor NOT LIKE '%[^a-zA-Z -.]%'),
  `time` TIME NULL,
  `creditHours` INT NULL CHECK (creditHours in (1,2,3,4,5)),
  PRIMARY KEY (`courseID`),
  UNIQUE INDEX `courseID_UNIQUE` (`courseID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`Enrollment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`Enrollment` (
  `User_studentID` INT NOT NULL,
  `Course_courseID` VARCHAR(11) NOT NULL,
  `grade` CHAR NULL CHECK (grade in ('A','B','C','D','F')), 
  PRIMARY KEY (`User_studentID`, `Course_courseID`),
  INDEX `fk_User_has_Course2_Course1_idx` (`Course_courseID` ASC),
  INDEX `fk_User_has_Course2_User1_idx` (`User_studentID` ASC),
  CONSTRAINT `fk_User_has_Course2_User1`
    FOREIGN KEY (`User_studentID`)
    REFERENCES `db_7180120_s19`.`User` (`studentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_User_has_Course2_Course1`
    FOREIGN KEY (`Course_courseID`)
    REFERENCES `db_7180120_s19`.`Course` (`courseID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_7180120_s19`.`Project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_7180120_s19`.`Project` (
  `TaskList_taskListID` INT NOT NULL,
  `User_studentID` INT NOT NULL,
  PRIMARY KEY (`TaskList_taskListID`, `User_studentID`),
  INDEX `fk_TaskList_has_User3_User1_idx` (`User_studentID` ASC),
  INDEX `fk_TaskList_has_User3_TaskList1_idx` (`TaskList_taskListID` ASC),
  CONSTRAINT `fk_TaskList_has_User3_TaskList1`
    FOREIGN KEY (`TaskList_taskListID`)
    REFERENCES `db_7180120_s19`.`TaskList` (`taskListID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_TaskList_has_User3_User1`
    FOREIGN KEY (`User_studentID`)
    REFERENCES `db_7180120_s19`.`User` (`studentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;