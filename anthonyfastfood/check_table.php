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
    } else {
        echo "Error getting table structure: " . $conn->error;
    }

    // Show sample data
    $result = $conn->query("SELECT * FROM staff LIMIT 1");
    if ($result) {
        echo "<h3>Sample Data (First Row):</h3>";
        echo "<table border='1'>";
        // Get field names
        $fields = $result->fetch_fields();
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";
        
        // Get data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error getting sample data: " . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 