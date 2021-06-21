CREATE
    DATABASE IF NOT EXISTS manager_note
    CHARACTER SET utf8 COLLATE utf8_vietnamese_ci;

use manager_note;


-- Create users table
CREATE TABLE IF NOT EXISTS users
(
    id       INT         NOT NULL AUTO_INCREMENT,
    email    VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

-- Create profiles table
CREATE TABLE IF NOT EXISTS profiles
(
    id      INT         NOT NULL AUTO_INCREMENT,
    user_id INT         NOT NULL,
    name    VARCHAR(25) NOT NULL,
    phone   CHAR(10)    NOT NULL,
        PRIMARY KEY (id)
);

-- Create table notes
CREATE TABLE IF NOT EXISTS notes
(
    id      INT  NOT NULL AUTO_INCREMENT,
    user_id INT  NOT NULL,
    title   TEXT NULL NULL,
    content TEXT NULL NULL,
    path    TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- Create foreign key FK_User_Profile
ALTER TABLE profiles
    ADD CONSTRAINT FK_User_Profile
        FOREIGN KEY (user_id) REFERENCES users (id);

-- Create foreign key FK_User_Note
ALTER TABLE notes
    ADD CONSTRAINT FK_User_Note
        FOREIGN KEY (user_id) REFERENCES users (id);

show tables;