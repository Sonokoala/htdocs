<?php
require_once 'part2/db.php';

$testEmails = [
    'manager@anthonyfastfood.com',
    'staff1@example.com',
    'test@example.com'
];

$testPasswords = [
    'Manager@123',
    'staff123',
    'Teststaff@123'
];

foreach ($testEmails as $email) {
    foreach ($testPasswords as $password) {
        $stmt = $connection->prepare("SELECT staffID, name, email, password_hash FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            echo "Testing: Email = $email, Password = $password\n";
            echo "Stored Hash: " . $user['password_hash'] . "\n";
            
            $verifyResult = password_verify($password, $user['password_hash']) ? 'Success' : 'Failed';
            echo "Verification Result: $verifyResult\n\n";
        }
        
        $stmt->close();
    }
}
?>
