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

    // Test accounts data
    $accounts = [
        [
            'email' => 'manager@example.com',
            'password' => 'manager123',
            'name' => 'Test Manager',
            'address' => '123 Manager St',
            'dateOfBirth' => '1985-01-01',
            'mob' => '0400000001',
            'roleID' => 1  // Manager role
        ],
        [
            'email' => 'supervisor@example.com',
            'password' => 'supervisor123',
            'name' => 'Test Supervisor',
            'address' => '456 Supervisor St',
            'dateOfBirth' => '1990-01-01',
            'mob' => '0400000002',
            'roleID' => 2  // Supervisor role
        ],
        [
            'email' => 'staff1@example.com',
            'password' => 'staff123',
            'name' => 'Test Staff 1',
            'address' => '789 Staff St',
            'dateOfBirth' => '1995-01-01',
            'mob' => '0400000003',
            'roleID' => 3  // Regular staff role
        ],
        [
            'email' => 'staff2@example.com',
            'password' => 'staff123',
            'name' => 'Test Staff 2',
            'address' => '321 Staff St',
            'dateOfBirth' => '1996-01-01',
            'mob' => '0400000004',
            'roleID' => 3  // Regular staff role
        ]
    ];

    echo "<h2>Creating Test Accounts</h2>";
    echo "<pre>";

    foreach ($accounts as $account) {
        // Check if account exists
        $stmt = $conn->prepare("SELECT staffID FROM staff WHERE email = ?");
        $stmt->bind_param("s", $account['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Account {$account['email']} already exists\n";
        } else {
            // Create the account
            $stmt = $conn->prepare("INSERT INTO staff (email, password_hash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $passwordHash = password_hash($account['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("ssssssi", 
                $account['email'],
                $passwordHash,
                $account['name'],
                $account['address'],
                $account['dateOfBirth'],
                $account['mob'],
                $account['roleID']
            );
            
            if ($stmt->execute()) {
                echo "Created account:\n";
                echo "Email: {$account['email']}\n";
                echo "Password: {$account['password']}\n";
                echo "Role: " . ($account['roleID'] == 1 ? "Manager" : ($account['roleID'] == 2 ? "Supervisor" : "Staff")) . "\n";
                echo "-------------------\n";
            } else {
                echo "Error creating account {$account['email']}: " . $stmt->error . "\n";
            }
        }
    }

    echo "</pre>";
    echo "<p>All test accounts have been processed.</p>";
    
    // Display all current staff accounts
    echo "<h2>Current Staff Accounts</h2>";
    $result = $conn->query("SELECT staffID, email, name, roleID FROM staff ORDER BY roleID, name");
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Role</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $role = $row['roleID'] == 1 ? "Manager" : ($row['roleID'] == 2 ? "Supervisor" : "Staff");
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($role) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";

    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
