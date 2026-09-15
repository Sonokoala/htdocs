<?php
require_once 'part2/db.php';

$newPassword = 'Manager@123';
$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$email = 'manager@anthonyfastfood.com';

$stmt = $connection->prepare("UPDATE staff SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $newHash, $email);
if ($stmt->execute()) {
    echo "Password hash for $email has been updated successfully.<br>";
    echo "New hash: $newHash";
} else {
    echo "Failed to update password hash for $email.";
}
$stmt->close();
$connection->close();
?>
