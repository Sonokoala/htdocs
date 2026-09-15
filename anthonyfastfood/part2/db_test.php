<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fastfood";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<h2>Database Connection Test Results:</h2>";
echo "<div style='margin: 20px; padding: 10px; border: 1px solid #ccc;'>";
echo "✅ Database connection successful!<br><br>";

// Test staff table
echo "<h3>Testing Staff Table:</h3>";
$query = "SELECT staffID, name, email, roleID FROM staff";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Staff ID</th><th>Name</th><th>Email</th><th>Role ID</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["staffID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["roleID"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No staff records found in the database.";
    }
} else {
    echo "Error executing staff query: " . $conn->error;
}

// Test availability table
echo "<h3>Testing Availability Table:</h3>";
$query = "SELECT a.staffID, s.name, a.rosterID, a.start_time, a.end_time 
          FROM availability a 
          JOIN staff s ON a.staffID = s.staffID";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Staff ID</th><th>Staff Name</th><th>Roster ID</th><th>Start Time</th><th>End Time</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["staffID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["rosterID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["start_time"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["end_time"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No availability records found in the database.";
    }
} else {
    echo "Error executing availability query: " . $conn->error;
}

// Test products table
echo "<h3>Testing Products Table:</h3>";
$query = "SHOW TABLES LIKE 'products'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $query = "SELECT * FROM products";
    $result = $conn->query($query);
    
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Description</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>$" . htmlspecialchars(number_format($row["price"], 2)) . "</td>";
                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No product records found in the database.";
        }
    } else {
        echo "Error executing products query: " . $conn->error;
    }
} else {
    echo "Products table does not exist.";
}

echo "</div>";
// Close connection
$conn->close();
?> 