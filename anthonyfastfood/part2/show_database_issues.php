<?php
require_once 'db.php';
require_once 'debug.php';

// Add CSS styles
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1, h2 { color: #333; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th { background-color: #4a90e2; color: white; padding: 12px 8px; }
    td { padding: 10px 8px; }
    tr:nth-child(even) { background-color: #f5f5f5; }
    tr:hover { background-color: #f0f7ff; }
    .warning { background-color: #fff3cd; padding: 15px; margin: 20px 0; border-radius: 5px; border-left: 5px solid #ffc107; }
    .container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
</style>";

echo "<h1>Database Structure Issues</h1>";

// 1. Display table structure
echo "<div class='container'>";
echo "<h2>1. Current Staff Table Structure</h2>";
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Field Name</th>";
    echo "<th>Data Type</th>";
    echo "<th>Null</th>";
    echo "<th>Key</th>";
    echo "<th>Default</th>";
    echo "<th>Extra</th>";
    echo "</tr>";
    
    $password_columns = [];
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
        
        // Record password-related columns
        if (stripos($row['Field'], 'password') !== false) {
            $password_columns[] = $row['Field'];
        }
    }
    echo "</table>";
    
    // Display issues
    if (count($password_columns) > 1) {
        echo "<div class='warning'>";
        echo "<h3>⚠️ Detected Issues</h3>";
        echo "<p>Multiple password columns found:</p>";
        echo "<ul>";
        foreach ($password_columns as $column) {
            echo "<li>" . $column . "</li>";
        }
        echo "</ul>";
        echo "<p><strong>Recommended fixes:</strong></p>";
        echo "<ul>";
        echo "<li>Consolidate into a single password column (password_hash)</li>";
        echo "<li>Migrate data from old column to new column</li>";
        echo "<li>Remove redundant columns</li>";
        echo "</ul>";
        echo "</div>";
    }
} else {
    echo "<p style='color: red;'>Failed to retrieve table structure: " . $connection->error . "</p>";
}
echo "</div>";

// 2. Display current staff data
echo "<div class='container' style='margin-top: 20px;'>";
echo "<h2>2. Current Staff Data</h2>";
$result = $connection->query("SELECT staffID, name, email, roleID FROM staff ORDER BY roleID, staffID");
if ($result) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Staff ID</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Role ID</th>";
    echo "<th>Role Description</th>";
    echo "</tr>";
    
    while ($row = $result->fetch_assoc()) {
        $role_description = match($row['roleID']) {
            1 => 'Administrator',
            2 => 'Manager',
            3 => 'Staff',
            default => 'Unknown Role'
        };
        
        $role_color = match($row['roleID']) {
            1 => '#dc3545',  // Red for Admin
            2 => '#fd7e14',  // Orange for Manager
            3 => '#28a745',  // Green for Staff
            default => '#6c757d'  // Gray for Unknown
        };
        
        echo "<tr>";
        echo "<td>" . $row['staffID'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['roleID'] . "</td>";
        echo "<td style='color: " . $role_color . "; font-weight: bold;'>" . $role_description . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Failed to retrieve staff data: " . $connection->error . "</p>";
}
echo "</div>";
?> 