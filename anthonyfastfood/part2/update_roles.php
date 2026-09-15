<?php
require_once 'db.php';

// First, create roles table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS roles (
    roleID INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
)";

if ($connection->query($sql) === TRUE) {
    echo "Roles table created successfully<br>";
} else {
    echo "Error creating roles table: " . $connection->error . "<br>";
}

// Insert or update standard roles
$roles = [
    [1, 'Manager', 'Full system access and staff management'],
    [2, 'Supervisor', 'Staff supervision and scheduling'],
    [3, 'Staff', 'Regular staff member']
];

$stmt = $connection->prepare("INSERT INTO roles (roleID, name, description) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description)");

foreach ($roles as $role) {
    $stmt->bind_param("iss", $role[0], $role[1], $role[2]);
    if ($stmt->execute()) {
        echo "Role updated: " . $role[1] . "<br>";
    } else {
        echo "Error updating role " . $role[1] . ": " . $stmt->error . "<br>";
    }
}

// Update any invalid roleIDs in staff table to Staff (3)
$sql = "UPDATE staff SET roleID = 3 WHERE roleID NOT IN (1, 2, 3)";
if ($connection->query($sql) === TRUE) {
    echo "Invalid role IDs updated to Staff role<br>";
} else {
    echo "Error updating invalid roles: " . $connection->error . "<br>";
}

$stmt->close();
$connection->close();

echo "<br><a href='db_test.php'>Return to Database Test</a>";
?> 