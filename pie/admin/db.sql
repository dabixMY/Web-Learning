-- Creating the database
CREATE DATABASE uecs2094_pie CHARACTER
SET
    utf8 COLLATE utf8_general_ci;

-- Creating the announcement table
USE uecs2094_pie;

CREATE TABLE
    announcement (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255),
        message TEXT,
        type CHAR(1),
        posted DATETIME
    );