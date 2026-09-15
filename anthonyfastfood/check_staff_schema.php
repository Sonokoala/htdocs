<?php
require_once 'part2/db.php';

// テーブルスキーマを取得
$query = "DESCRIBE staff";
$result = $connection->query($query);

if ($result) {
    echo "Staff Table Schema:\n";
    while ($row = $result->fetch_assoc()) {
        echo "Field: " . $row['Field'] . 
             ", Type: " . $row['Type'] . 
             ", Null: " . $row['Null'] . 
             ", Key: " . $row['Key'] . 
             ", Default: " . ($row['Default'] ?? 'NULL') . 
             ", Extra: " . $row['Extra'] . "\n";
    }
} else {
    echo "Error retrieving table schema: " . $connection->error;
}

// サンプルユーザーの確認
$userQuery = "SELECT staffID, email, password_hash FROM staff LIMIT 5";
$userResult = $connection->query($userQuery);

if ($userResult) {
    echo "\nSample Users:\n";
    while ($user = $userResult->fetch_assoc()) {
        echo "ID: " . $user['staffID'] . 
             ", Email: " . $user['email'] . 
             ", Password Hash Length: " . strlen($user['password_hash']) . "\n";
    }
} else {
    echo "Error retrieving users: " . $connection->error;
}
?>
