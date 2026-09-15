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

    echo "<h2>Database Check</h2>";
    
    // Check if role table exists
    $result = $conn->query("SHOW TABLES LIKE 'role'");
    if ($result->num_rows > 0) {
        echo "<p>Role table exists.</p>";
        
        // Check role table content
        $result = $conn->query("SELECT * FROM role");
        if ($result->num_rows > 0) {
            echo "<h3>Role Table Content</h3>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>roleID</th><th>name</th><th>description</th><th>ratehour</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['roleID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ratehour']) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>Role table is empty.</p>";
            
            // Create default roles
            echo "<h3>Creating Default Roles</h3>";
            
            $roles = [
                [1, 'Manager', 'Store Manager', 25.00],
                [2, 'Supervisor', 'Shift Supervisor', 22.00],
                [3, 'Staff', 'Regular Staff', 20.00]
            ];
            
            foreach ($roles as $role) {
                $stmt = $conn->prepare("INSERT INTO role (roleID, name, description, ratehour) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issd", $role[0], $role[1], $role[2], $role[3]);
                
                if ($stmt->execute()) {
                    echo "Created role: " . htmlspecialchars($role[1]) . "<br>";
                } else {
                    echo "Error creating role " . htmlspecialchars($role[1]) . ": " . $stmt->error . "<br>";
                }
            }
        }
    } else {
        echo "<p>Role table does not exist.</p>";
        
        // Create role table
        echo "<h3>Creating Role Table</h3>";
        
        $sql = "CREATE TABLE role (
            roleID INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(15) NOT NULL,
            description VARCHAR(30) NOT NULL,
            ratehour DECIMAL(5,2) NOT NULL
        )";
        
        if ($conn->query($sql)) {
            echo "<p>Role table created successfully.</p>";
            
            // Create default roles
            echo "<h3>Creating Default Roles</h3>";
            
            $roles = [
                [1, 'Manager', 'Store Manager', 25.00],
                [2, 'Supervisor', 'Shift Supervisor', 22.00],
                [3, 'Staff', 'Regular Staff', 20.00]
            ];
            
            foreach ($roles as $role) {
                $stmt = $conn->prepare("INSERT INTO role (roleID, name, description, ratehour) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issd", $role[0], $role[1], $role[2], $role[3]);
                
                if ($stmt->execute()) {
                    echo "Created role: " . htmlspecialchars($role[1]) . "<br>";
                } else {
                    echo "Error creating role " . htmlspecialchars($role[1]) . ": " . $stmt->error . "<br>";
                }
            }
        } else {
            echo "<p>Error creating role table: " . $conn->error . "</p>";
        }
    }
    
    // List all tables
    echo "<h3>All Tables</h3>";
    $result = $conn->query("SHOW TABLES");
    
    echo "<ul>";
    while ($row = $result->fetch_row()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";
    
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
