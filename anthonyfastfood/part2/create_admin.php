<?php
require_once "db.php";

// 管理者のみ実行可能
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("HTTP/1.1 403 Forbidden");
    exit("Access denied. Manager privileges required.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($username) || empty($password) || empty($name)) {
        die("Username, password and name are required");
    }
    
    if (strlen($password) < 12) {
        die("Password must be at least 12 characters");
    }
    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $connection->prepare("INSERT INTO staff (username, password_hash, name, role) VALUES (?, ?, ?, 'manager')");
    $stmt->bind_param("sss", $username, $hashedPassword, $name);
    
    if ($stmt->execute()) {
        echo "Admin account created successfully";
    } else {
        echo "Error creating admin account: " . $connection->error;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Admin Account</title>
</head>
<body>
    <h1>Create Admin Account</h1>
    <form method="post">
        <div>
            <label>Username: <input type="text" name="username" required></label>
        </div>
        <div>
            <label>Password: <input type="password" name="password" required minlength="12"></label>
        </div>
        <div>
            <label>Full Name: <input type="text" name="name" required></label>
        </div>
        <button type="submit">Create Admin</button>
    </form>
</body>
</html>
