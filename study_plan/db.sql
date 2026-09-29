-- Task 2: Database (db.sql)
-- a) Create the study_plan database with collation utf8_general_ci
CREATE DATABASE IF NOT EXISTS study_plan DEFAULT CHARACTER
SET
    utf8 DEFAULT COLLATE utf8_general_ci;

USE study_plan;

-- b) students table
CREATE TABLE
    IF NOT EXISTS students (
        student_id INT NOT NULL,
        name VARCHAR(100),
        email VARCHAR(100),
        password VARCHAR(255),
        PRIMARY KEY (student_id)
    ) ENGINE = MyISAM DEFAULT COLLATE = utf8_general_ci;

-- c) student_courses table
-- Note: courses table (imported separately from courses.sql) uses MyISAM,
-- so student_courses is also created as MyISAM for engine compatibility.
CREATE TABLE
    IF NOT EXISTS student_courses (
        student_id INT NOT NULL,
        course_id INT NOT NULL,
        PRIMARY KEY (student_id, course_id),
        FOREIGN KEY (student_id) REFERENCES students (student_id),
        FOREIGN KEY (course_id) REFERENCES courses (course_id)
    ) ENGINE = MyISAM DEFAULT COLLATE = utf8_general_ci;

-- After running this file, import the provided courses.sql into the
-- study_plan database (via phpMyAdmin "Import") to create/populate
-- the courses table, as instructed in the question paper.