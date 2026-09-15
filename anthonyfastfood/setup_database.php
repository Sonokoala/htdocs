<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Create staff table with correct structure
$createTableSQL = "CREATE TABLE IF NOT EXISTS staff (
    staffID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'staff',
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($connection->query($createTableSQL)) {
    echo "Staff table created successfully or already exists.<br>";
} else {
    echo "Error creating staff table: " . $connection->error . "<br>";
}

// Insert a test staff member with hashed password
$testUsername = "teststaff";
$testPassword = password_hash("password123", PASSWORD_DEFAULT);
$testName = "Test Staff";
$testRole = "staff";

$insertSQL = "INSERT INTO staff (username, password, name, role) 
              VALUES (?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
              password = VALUES(password),
              name = VALUES(name),
              role = VALUES(role)";

if ($stmt = $connection->prepare($insertSQL)) {
    $stmt->bind_param("ssss", $testUsername, $testPassword, $testName, $testRole);
    if ($stmt->execute()) {
        echo "Test staff member created/updated successfully.<br>";
    } else {
        echo "Error inserting test staff: " . $stmt->error . "<br>";
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $connection->error . "<br>";
}

// Show current table structure
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "<h3>Current Staff Table Structure:</h3>";
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
    echo "Error showing table structure: " . $connection->error;
}

// Show current staff members
$result = $connection->query("SELECT staffID, username, name, role FROM staff");
if ($result) {
    echo "<h3>Current Staff Members:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Error showing staff members: " . $connection->error;
}

$connection->close();
echo "<br><br>Test login credentials:<br>";
echo "Username: teststaff<br>";
echo "Password: password123";
?> 