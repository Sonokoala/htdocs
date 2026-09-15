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
    
    // Test user data
    $email = "teststaff@example.com";
    $password = password_hash("password123", PASSWORD_DEFAULT);
    $name = "Test Staff";
    $address = "123 Test St";
    $dateOfBirth = "1990-01-01";
    $mob = "0400000000";
    $roleID = 1;  // Assuming 1 is a valid role ID

    // First check if the user already exists
    $stmt = $conn->prepare("SELECT staffID FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Test user already exists<br>";
    } else {
        // Create the test user
        $stmt = $conn->prepare("INSERT INTO staff (email, passwordHash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $email, $password, $name, $address, $dateOfBirth, $mob, $roleID);
        
        if ($stmt->execute()) {
            echo "Test user created successfully<br>";
            echo "Login credentials:<br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Password: password123<br>";
        } else {
            throw new Exception("Error creating test user: " . $stmt->error);
        }
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 