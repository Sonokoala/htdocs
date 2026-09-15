<?php
require_once 'db.php';
require_once 'debug.php';

echo "<h1>Password Column Consolidation</h1>";

try {
    // Step 1: Check if both columns exist
    echo "<h2>Step 1: Checking columns...</h2>";
    $columns = $connection->query("SHOW COLUMNS FROM staff");
    $has_password_hash = false;
    $has_passwordHash = false;
    
    while ($column = $columns->fetch_assoc()) {
        if ($column['Field'] === 'password_hash') {
            $has_password_hash = true;
        }
        if ($column['Field'] === 'passwordHash') {
            $has_passwordHash = true;
        }
    }
    
    echo "Found columns:<br>";
    echo "- password_hash: " . ($has_password_hash ? "Yes" : "No") . "<br>";
    echo "- passwordHash: " . ($has_passwordHash ? "Yes" : "No") . "<br>";

    // Step 2: Create password_hash column if it doesn't exist
    echo "<h2>Step 2: Creating/Checking password_hash column...</h2>";
    if (!$has_password_hash) {
        $sql = "ALTER TABLE staff ADD COLUMN password_hash VARCHAR(255) NOT NULL DEFAULT ''";
        if ($connection->query($sql)) {
            echo "✅ password_hash column created successfully<br>";
        } else {
            throw new Exception("Error creating password_hash column: " . $connection->error);
        }
    } else {
        echo "✅ password_hash column already exists<br>";
    }

    // Step 3: Migrate data from passwordHash to password_hash
    echo "<h2>Step 3: Migrating data...</h2>";
    if ($has_passwordHash) {
        $sql = "UPDATE staff SET password_hash = passwordHash WHERE passwordHash IS NOT NULL AND passwordHash != ''";
        if ($connection->query($sql)) {
            echo "✅ Data migrated successfully from passwordHash to password_hash<br>";
            
            // Count migrated rows
            $result = $connection->query("SELECT COUNT(*) as count FROM staff WHERE password_hash != ''");
            $row = $result->fetch_assoc();
            echo "Number of migrated passwords: " . $row['count'] . "<br>";
        } else {
            throw new Exception("Error migrating data: " . $connection->error);
        }
    } else {
        echo "No data migration needed (old column doesn't exist)<br>";
    }

    // Step 4: Verify data migration
    echo "<h2>Step 4: Verifying migration...</h2>";
    $result = $connection->query("SELECT staffID, email, 
        CASE WHEN password_hash != '' THEN 'Yes' ELSE 'No' END as has_new_password,
        CASE WHEN passwordHash != '' THEN 'Yes' ELSE 'No' END as has_old_password 
        FROM staff");
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th style='padding: 8px;'>Staff ID</th>";
    echo "<th style='padding: 8px;'>Email</th>";
    echo "<th style='padding: 8px;'>Has New Password</th>";
    echo "<th style='padding: 8px;'>Has Old Password</th>";
    echo "</tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 8px;'>" . $row['staffID'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['email'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['has_new_password'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['has_old_password'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Step 5: Remove old passwordHash column
    echo "<h2>Step 5: Removing old column...</h2>";
    if ($has_passwordHash) {
        $sql = "ALTER TABLE staff DROP COLUMN passwordHash";
        if ($connection->query($sql)) {
            echo "✅ Old passwordHash column removed successfully<br>";
        } else {
            throw new Exception("Error removing old column: " . $connection->error);
        }
    } else {
        echo "No need to remove old column (doesn't exist)<br>";
    }

    // Final verification
    echo "<h2>Final Verification</h2>";
    $columns = $connection->query("SHOW COLUMNS FROM staff");
    echo "Current table structure:<br>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th style='padding: 8px;'>Field</th>";
    echo "<th style='padding: 8px;'>Type</th>";
    echo "<th style='padding: 8px;'>Null</th>";
    echo "<th style='padding: 8px;'>Key</th>";
    echo "<th style='padding: 8px;'>Default</th>";
    echo "</tr>";
    
    while ($column = $columns->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 8px;'>" . $column['Field'] . "</td>";
        echo "<td style='padding: 8px;'>" . $column['Type'] . "</td>";
        echo "<td style='padding: 8px;'>" . $column['Null'] . "</td>";
        echo "<td style='padding: 8px;'>" . $column['Key'] . "</td>";
        echo "<td style='padding: 8px;'>" . $column['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h2>✅ Process Completed Successfully</h2>";
    echo "The password columns have been consolidated into a single 'password_hash' column.";

} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>";
    echo "Error: " . $e->getMessage();
    echo "</div>";
}
?> 