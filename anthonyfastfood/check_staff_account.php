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

    echo "<h2>Staff Account Check</h2>";
    
    // Check for staff1@example.com account
    $email = "staff1@example.com";
    $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<h3>Account Found: {$email}</h3>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        // Check if password_hash column exists and has value
        echo "<p>Password hash column check:</p>";
        echo "password_hash column exists: " . (isset($user['password_hash']) ? "Yes" : "No") . "<br>";
        echo "password_hash value is set: " . (!empty($user['password_hash']) ? "Yes" : "No") . "<br>";
        
        // Test password verification
        $testPassword = "staff123";
        $passwordVerified = isset($user['password_hash']) && password_verify($testPassword, $user['password_hash']);
        echo "Password 'staff123' verification: " . ($passwordVerified ? "Success" : "Failed") . "<br>";
        
    } else {
        echo "<h3>Account Not Found: {$email}</h3>";
        
        // Create the account if it doesn't exist
        echo "<h3>Creating Test Account</h3>";
        $stmt = $conn->prepare("INSERT INTO staff (email, password_hash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $password = "staff123";
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $name = "Test Staff 1";
        $address = "789 Staff St";
        $dateOfBirth = "1995-01-01";
        $mob = "0400000003";
        $roleID = 3; // Regular staff role
        
        $stmt->bind_param("ssssssi", 
            $email,
            $passwordHash,
            $name,
            $address,
            $dateOfBirth,
            $mob,
            $roleID
        );
        
        if ($stmt->execute()) {
            echo "Account created successfully:<br>";
            echo "Email: {$email}<br>";
            echo "Password: {$password}<br>";
            echo "Role: Staff<br>";
        } else {
            echo "Error creating account: " . $stmt->error . "<br>";
        }
    }
    
    // Show all staff accounts
    echo "<h3>All Staff Accounts</h3>";
    $result = $conn->query("SELECT staffID, email, name, roleID, password_hash FROM staff ORDER BY roleID, name");
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Role</th><th>Has Password</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $role = $row['roleID'] == 1 ? "Manager" : ($row['roleID'] == 2 ? "Supervisor" : "Staff");
        $hasPassword = !empty($row['password_hash']) ? "Yes" : "No";
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($role) . "</td>";
        echo "<td>" . $hasPassword . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";

    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
