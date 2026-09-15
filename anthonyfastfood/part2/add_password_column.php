<?php
require_once 'db.php';
require_once 'debug.php';

// First, check if the password column exists
$result = $connection->query("SHOW COLUMNS FROM staff LIKE 'password'");
$columnExists = $result->num_rows > 0;

if (!$columnExists) {
    // Add password column
    $sql = "ALTER TABLE staff ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ''";
    if ($connection->query($sql)) {
        echo "Password column added successfully<br>";
        
        // Add a default password for staff1@example.com
        $default_password = password_hash('password123', PASSWORD_DEFAULT);
        $update_sql = "UPDATE staff SET password = ? WHERE email = 'staff1@example.com'";
        $stmt = $connection->prepare($update_sql);
        
        if ($stmt === false) {
            echo "Error preparing statement: " . $connection->error . "<br>";
        } else {
            $stmt->bind_param('s', $default_password);
            
            if ($stmt->execute()) {
                echo "Default password set for staff1@example.com<br>";
                echo "Test account credentials:<br>";
                echo "Email: staff1@example.com<br>";
                echo "Password: password123<br>";
            } else {
                echo "Error setting default password: " . $stmt->error . "<br>";
            }
            $stmt->close();
        }
    } else {
        echo "Error adding password column: " . $connection->error . "<br>";
    }
} else {
    echo "Password column already exists<br>";
    
    // Update the test account password anyway
    $default_password = password_hash('password123', PASSWORD_DEFAULT);
    $update_sql = "UPDATE staff SET password = ? WHERE email = 'staff1@example.com'";
    $stmt = $connection->prepare($update_sql);
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $connection->error . "<br>";
    } else {
        $stmt->bind_param('s', $default_password);
        
        if ($stmt->execute()) {
            echo "Test account password updated<br>";
            echo "Test account credentials:<br>";
            echo "Email: staff1@example.com<br>";
            echo "Password: password123<br>";
        } else {
            echo "Error updating test account password: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

// Display current staff table structure
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "<br>Current staff table structure:<br>";
    echo "<pre>";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
}

// Display test account data
$result = $connection->query("SELECT staffID, name, email FROM staff WHERE email = 'staff1@example.com'");
if ($result && $row = $result->fetch_assoc()) {
    echo "<br>Test account details:<br>";
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}
?> 