CREATE DATABASE IF NOT EXISTS fastfood CHARACTER SET utf8mb4;
USE fastfood;

-- Create role table first as it's referenced by other tables
CREATE TABLE IF NOT EXISTS role (
    roleID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(15) NOT NULL,
    description VARCHAR(30) NOT NULL,
    ratehour DECIMAL(5,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS staff (
    staffID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    dateOfBirth DATE NOT NULL,
    email VARCHAR(30) NOT NULL,
    mob VARCHAR(10) NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    roleID INT NOT NULL,
    INDEX (email)
);

-- Add foreign key constraints after all tables are created
ALTER TABLE staff ADD FOREIGN KEY (roleID) REFERENCES role(roleID);

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
    UNIQUE KEY (staffID, rosterID)
);

-- Add foreign key constraints after all tables are created
ALTER TABLE availability ADD FOREIGN KEY (staffID) REFERENCES staff(staffID);
ALTER TABLE availability ADD FOREIGN KEY (rosterID) REFERENCES roster(rosterID);

-- Insert test data
INSERT INTO role 
(`roleID`, `name`, `description`, `ratehour`) VALUES
(1, 'cook', 'works in kitchen', '50.50'),
(2, 'waiter', 'front desk', '40.50'),
(3, 'supervisor', 'of branch', '70.50'),
(4, 'manager', 'of area', '100.00');

INSERT INTO staff
(`staffID`, `name`, `address`, `dateOfBirth`, `email`, `mob`, `passwordHash`, `roleID`) VALUES
(1, 'staff1', 'address1', '2020-09-01', 'email1@test.com', 'mob1', '', 1),
(2, 'staff2', 'address2', '2021-09-01', 'email2@test.com', 'mob2', '', 1),
(3, 'staff3', 'address3', '2022-09-01', 'email3@test.com', 'mob3', '', 1),
(4, 'staff4', 'address4', '2023-09-01', 'email4@test.com', 'mob4', '', 2),
(5, 'staff5', 'address5', '2024-09-01', 'email5@test.com', 'mob5', '', 3),
(6, 'staff6', 'address6', '2025-09-01', 'email6@test.com', 'mob6', '', 4);

INSERT INTO roster
(`rosterID`, `dateTimeFrom`, `dateTimeTo`) VALUES
(1, '2023-05-01 08:00:00', '2023-05-01 17:00:00'),
(2, '2023-05-01 17:00:00', '2023-05-01 22:00:00'),
(3, '2023-05-02 08:00:00', '2023-05-02 17:00:00'),
(4, '2023-05-02 17:00:00', '2023-05-02 22:00:00'),
(5, '2023-05-03 08:00:00', '2023-05-03 17:00:00'),
(6, '2023-05-03 17:00:00', '2023-05-03 22:00:00'),
(7, '2023-05-04 08:00:00', '2023-05-04 17:00:00'),
(8, '2023-05-04 17:00:00', '2023-05-04 22:00:00');

INSERT INTO rosterrole
(`RosterRoleID`, `qty`, `rosterID`, `roleID`) VALUES
(1, 5, 1, 1),
(2, 6, 1, 2),
(3, 5, 2, 1),
(4, 1, 2, 3),
(5, 3, 2, 2),
(6, 1, 1, 4);
