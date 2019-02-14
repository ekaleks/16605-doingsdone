CREATE DATABASE things_in_order
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE things_in_order;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(64) NOT NULL,
    user_id INT NOT NULL UNIQUE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_creation TIMESTAMP NOT NULL,
    date_completion TIMESTAMP NOT NULL,
    title CHAR(128) NOT NULL,
    user_file CHAR(128),
    deadline TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    project_id INT NOT NULL UNIQUE,
    status TINYINT DEFAULT 0
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    e_mail CHAR(128) NOT NULL UNIQUE,
    username CHAR(64) NOT NULL UNIQUE,
    user_password CHAR(64) NOT NULL
);
