<?php
require_once 'db.php';

// Test database connection
try {
    $result = $connection->query("SELECT 1");
    echo "Database connection successful!<br>";
    
    // Check staff table exists
    $tables = $connection->query("SHOW TABLES LIKE 'staff'");
    if ($tables->num_rows > 0) {
        echo "Staff table exists.<br>";
        
        // Check manager account
        $stmt = $connection->prepare("SELECT email, password_hash FROM staff WHERE email = ?");
        $managerEmail = "manager@anthonyfastfood.com";
        $stmt->bind_param("s", $managerEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Manager account found. Password hash: " . $user['password_hash'] . "<br>";
            
            // Verify password
            if (password_verify("Manager@123", $user['password_hash'])) {
                echo "Password verification SUCCESS for manager account!";
            } else {
                echo "Password verification FAILED for manager account!";
            }
        } else {
            echo "Manager account not found in database!";
        }
    } else {
        echo "Staff table does not exist!";
    }
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
