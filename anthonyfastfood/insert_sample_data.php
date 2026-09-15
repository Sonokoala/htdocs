<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Insert staff data
$staffQuery = "INSERT INTO staff (staffID, name, roleID) 
               VALUES (3, 'staff3', 1) 
               ON DUPLICATE KEY UPDATE name='staff3', roleID=1";
$connection->query($staffQuery);

// Insert roster data
$rosterQuery = "INSERT INTO roster (rosterID, dateTimeFrom, dateTimeTo) 
                VALUES 
                (1, '2023-05-01 08:00:00', '2023-05-01 17:00:00'),
                (2, '2023-05-01 17:00:00', '2023-05-01 22:00:00')
                ON DUPLICATE KEY UPDATE 
                dateTimeFrom=VALUES(dateTimeFrom), 
                dateTimeTo=VALUES(dateTimeTo)";
$connection->query($rosterQuery);

// Insert availability data
$availabilityQuery = "INSERT INTO availability (staffID, rosterID, start_time, end_time) 
                      VALUES 
                      (3, 1, '2023-05-01 08:00:00', '2023-05-01 17:00:00'),
                      (3, 2, '2023-05-01 17:00:00', '2023-05-01 22:00:00')
                      ON DUPLICATE KEY UPDATE 
                      start_time=VALUES(start_time), 
                      end_time=VALUES(end_time)";
$connection->query($availabilityQuery);

echo "Sample data has been inserted successfully!";
$connection->close();
?> 