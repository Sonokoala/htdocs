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

    echo "<h2>Staff Table Check</h2>";
    
    // Check if staff table exists
    $result = $conn->query("SHOW TABLES LIKE 'staff'");
    if ($result->num_rows > 0) {
        echo "<p>Staff table exists.</p>";
        
        // Check staff table structure
        echo "<h3>Staff Table Structure</h3>";
        $result = $conn->query("DESCRIBE staff");
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Check staff table content
        echo "<h3>Staff Table Content</h3>";
        $result = $conn->query("SELECT * FROM staff");
        
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>";
            
            // Get column names
            $columns = [];
            while ($fieldInfo = $result->fetch_field()) {
                $columns[] = $fieldInfo->name;
            }
            
            // Print header row
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>" . htmlspecialchars($column) . "</th>";
            }
            echo "</tr>";
            
            // Reset result pointer
            $result->data_seek(0);
            
            // Print data rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    // Special handling for password_hash to avoid displaying the full hash
                    if ($column === 'password_hash') {
                        echo "<td>" . (empty($row[$column]) ? 'NULL' : '[HASH]') . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($row[$column] ?? 'NULL') . "</td>";
                    }
                }
                echo "</tr>";
            }
            
            echo "</table>";
            
            // Check for staff1@example.com specifically
            echo "<h3>Check for staff1@example.com</h3>";
            $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
            $email = "staff1@example.com";
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo "<p>Found staff1@example.com with roleID: " . htmlspecialchars($user['roleID']) . "</p>";
                
                // Check if the role exists
                $stmt = $conn->prepare("SELECT * FROM role WHERE roleID = ?");
                $stmt->bind_param("i", $user['roleID']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $role = $result->fetch_assoc();
                    echo "<p>Role found: " . htmlspecialchars($role['name']) . " (" . htmlspecialchars($role['description']) . ")</p>";
                } else {
                    echo "<p>Error: Role with ID " . htmlspecialchars($user['roleID']) . " does not exist!</p>";
                }
                
                // Test password verification
                $testPassword = "staff123";
                $passwordVerified = isset($user['password_hash']) && password_verify($testPassword, $user['password_hash']);
                echo "<p>Password 'staff123' verification: " . ($passwordVerified ? "Success" : "Failed") . "</p>";
                
            } else {
                echo "<p>staff1@example.com not found in the database.</p>";
            }
        } else {
            echo "<p>Staff table is empty.</p>";
        }
    } else {
        echo "<p>Staff table does not exist.</p>";
    }
    
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
