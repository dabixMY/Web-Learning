CREATE DATABASE lab9 CHARACTER
SET
    utf8 COLLATE utf8_general_ci;

USE lab9;

CREATE TABLE
    users (
        id INT (11) NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    );