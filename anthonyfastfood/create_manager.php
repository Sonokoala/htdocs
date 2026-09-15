<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

try {
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Manager account data
    $email = "manager@example.com";
    $password = password_hash("manager123", PASSWORD_DEFAULT);
    $name = "Test Manager";
    $address = "123 Manager St";
    $dateOfBirth = "1985-01-01";
    $mob = "0400000001";
    $roleID = 1;  // 1 for Manager role

    // First check if the user already exists
    $stmt = $conn->prepare("SELECT staffID FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Manager account already exists<br>";
    } else {
        // Create the manager account
        $stmt = $conn->prepare("INSERT INTO staff (email, passwordHash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $email, $password, $name, $address, $dateOfBirth, $mob, $roleID);
        
        if ($stmt->execute()) {
            echo "Manager account created successfully<br>";
            echo "Login credentials:<br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Password: manager123<br>";
        } else {
            throw new Exception("Error creating manager account: " . $stmt->error);
        }
    }

    // Create a supervisor account as well
    $email = "supervisor@example.com";
    $password = password_hash("supervisor123", PASSWORD_DEFAULT);
    $name = "Test Supervisor";
    $roleID = 2;  // 2 for Supervisor role

    // Check if supervisor exists
    $stmt = $conn->prepare("SELECT staffID FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Supervisor account already exists<br>";
    } else {
        // Create the supervisor account
        $stmt = $conn->prepare("INSERT INTO staff (email, passwordHash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $email, $password, $name, $address, $dateOfBirth, $mob, $roleID);
        
        if ($stmt->execute()) {
            echo "Supervisor account created successfully<br>";
            echo "Login credentials:<br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Password: supervisor123<br>";
        } else {
            throw new Exception("Error creating supervisor account: " . $stmt->error);
        }
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 