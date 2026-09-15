<?php
require_once 'db.php';

header('Content-Type: text/plain');

// Check staff table structure
echo "=== Staff Table Structure ===\n";
$result = $connection->query("DESCRIBE staff");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . "\n";
    }
} else {
    echo "Error describing staff table: " . $connection->error . "\n";
}

// Check accounts
echo "\n=== Staff Accounts ===\n";
$accounts = [
    "manager@anthonyfastfood.com" => "Manager@123",
    "staff1@example.com" => "staff123", 
    "test@example.com" => "Teststaff@123"
];

foreach ($accounts as $email => $password) {
    echo "\nChecking account: $email\n";
    
    $stmt = $connection->prepare("SELECT staffID, email, password_hash FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "Account found:\n";
        echo "ID: " . $user['staffID'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Password hash: " . $user['password_hash'] . "\n";
        
        if (password_verify($password, $user['password_hash'])) {
            echo "Password verification: SUCCESS\n";
        } else {
            echo "Password verification: FAILED\n";
            echo "Generating new hash for password: $password\n";
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            echo "New hash: $newHash\n";
            
            // Update hash in database
            $update = $connection->prepare("UPDATE staff SET password_hash = ? WHERE email = ?");
            $update->bind_param("ss", $newHash, $email);
            if ($update->execute()) {
                echo "Password hash updated successfully\n";
            } else {
                echo "Failed to update password hash: " . $connection->error . "\n";
            }
        }
    } else {
        echo "Account not found in database\n";
    }
}
?>
