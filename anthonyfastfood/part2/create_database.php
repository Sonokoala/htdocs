<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    // Create connection without database
    $conn = new mysqli($servername, $username, $password);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS fastfood";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the database
    $conn->select_db("fastfood");
    
    // Create staff table
    $sql = "CREATE TABLE IF NOT EXISTS staff (
        staffID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        roleID INT NOT NULL DEFAULT 3,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Staff table created successfully<br>";
    } else {
        throw new Exception("Error creating staff table: " . $conn->error);
    }
    
    // Create roles table
    $sql = "CREATE TABLE IF NOT EXISTS roles (
        roleID INT PRIMARY KEY,
        role_name VARCHAR(50) NOT NULL,
        description TEXT
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Roles table created successfully<br>";
        
        // Insert default roles
        $roles = [
            [1, 'Administrator', 'Full system access'],
            [2, 'Manager', 'Staff management and operations'],
            [3, 'Staff', 'Basic system access']
        ];
        
        foreach ($roles as $role) {
            $sql = "INSERT IGNORE INTO roles (roleID, role_name, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $role[0], $role[1], $role[2]);
            $stmt->execute();
        }
        
        echo "Default roles inserted successfully<br>";
    } else {
        throw new Exception("Error creating roles table: " . $conn->error);
    }
    
    $conn->close();
    echo "Database setup completed successfully!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 