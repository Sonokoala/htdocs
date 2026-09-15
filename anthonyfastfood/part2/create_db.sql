CREATE DATABASE IF NOT EXISTS fastfood CHARACTER SET utf8mb4;
USE fastfood;

CREATE TABLE IF NOT EXISTS staff (
    staffID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    dateOfBirth DATE NOT NULL,
    email VARCHAR(30) NOT NULL,
    mob VARCHAR(10) NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    roleID INT NOT NULL,
    FOREIGN KEY (roleID) REFERENCES role(roleID),
    INDEX (email)
);



CREATE TABLE IF NOT EXISTS role (
    roleID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(15) NOT NULL,
    description VARCHAR(30) NOT NULL,
    ratehour DECIMAL(5,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS roster (
    rosterID INT AUTO_INCREMENT PRIMARY KEY,
    dateTimeFrom DATETIME NOT NULL,
    dateTimeTo DATETIME NOT NULL,
    notes TEXT
);

CREATE TABLE IF NOT EXISTS rosterrole (
    rosterRoleID INT AUTO_INCREMENT PRIMARY KEY,
    qty INT NOT NULL,
    rosterID INT NOT NULL,
    roleID INT NOT NULL,
    FOREIGN KEY (rosterID) REFERENCES roster(rosterID),
    FOREIGN KEY (roleID) REFERENCES role(roleID),
    UNIQUE KEY (roleID, rosterID)
);

CREATE TABLE IF NOT EXISTS availability (
    availID INT AUTO_INCREMENT PRIMARY KEY,
    dateTimeFrom DATETIME,
    dateTimeTo DATETIME,
    staffID INT NOT NULL,
    rosterID INT NOT NULL,
    FOREIGN KEY (staffID) REFERENCES staff(staffID),
    FOREIGN KEY (rosterID) REFERENCES roster(rosterID),
    UNIQUE KEY (staffID, rosterID)
);
