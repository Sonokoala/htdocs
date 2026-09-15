<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";

try {
    // Create connection without database
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully<br>";

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS fastfood";
    if ($conn->query($sql)) {
        echo "Database 'fastfood' created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Select the database
    $conn->select_db("fastfood");

    // Drop existing staff table if exists
    $sql = "DROP TABLE IF EXISTS staff";
    if ($conn->query($sql)) {
        echo "Old staff table dropped successfully<br>";
    }

    // Create staff table with correct structure
    $sql = "CREATE TABLE staff (
        staffID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'staff',
        email VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql)) {
        echo "Table 'staff' created successfully<br>";
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }

    // Insert test user
    $testUsername = "teststaff";
    $testPassword = password_hash("password123", PASSWORD_DEFAULT);
    $testName = "Test Staff";
    $testRole = "staff";

    $stmt = $conn->prepare("INSERT INTO staff (username, password, name, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $testUsername, $testPassword, $testName, $testRole);
    
    if ($stmt->execute()) {
        echo "Test user created successfully<br>";
    } else {
        throw new Exception("Error creating test user: " . $stmt->error);
    }
    $stmt->close();

    // Show current table structure
    $result = $conn->query("DESCRIBE staff");
    if ($result) {
        echo "<h3>Staff Table Structure:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // Show current users
    $result = $conn->query("SELECT staffID, username, name, role FROM staff");
    if ($result) {
        echo "<h3>Current Staff Members:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    echo "<br><br>Test login credentials:<br>";
    echo "Username: teststaff<br>";
    echo "Password: password123<br>";

    $conn->close();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 