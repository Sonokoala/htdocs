<?php
require_once 'db.php';
require_once 'debug.php';

// テーブルが存在しない場合は作成
$create_table = "CREATE TABLE IF NOT EXISTS staff (
    staffID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    roleID INT NOT NULL DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($connection->query($create_table)) {
    echo "スタッフテーブルが正常に作成されました<br>";
} else {
    echo "スタッフテーブルの作成中にエラーが発生しました: " . $connection->error . "<br>";
}

// 既存のpasswordカラムがある場合は削除（新しい構造に移行）
$sql = "ALTER TABLE staff DROP COLUMN IF EXISTS password";
$connection->query($sql);

// password_hashカラムがない場合は追加
$sql = "ALTER TABLE staff ADD COLUMN IF NOT EXISTS password_hash VARCHAR(255) NOT NULL DEFAULT ''";
if ($connection->query($sql)) {
    echo "password_hashカラムが正常に追加されました<br>";
} else {
    echo "password_hashカラムの追加中にエラーが発生しました: " . $connection->error . "<br>";
}

// 管理者アカウントの設定
$admin_email = 'admin@anthonyfastfood.com';
$admin_password = password_hash('Admin@123', PASSWORD_DEFAULT);
$admin_name = 'System Administrator';
$admin_role = 1; // 1 = admin role

// マネージャーアカウントの設定
$manager_email = 'manager@anthonyfastfood.com';
$manager_password = password_hash('Manager@123', PASSWORD_DEFAULT);
$manager_name = 'Store Manager';
$manager_role = 2; // 2 = manager role

// 管理者アカウントの作成または更新
$check_admin = $connection->prepare("SELECT staffID FROM staff WHERE email = ?");
$check_admin->bind_param('s', $admin_email);
$check_admin->execute();
$result = $check_admin->get_result();

if ($result->num_rows > 0) {
    // 既存の管理者アカウントを更新
    $update = $connection->prepare("UPDATE staff SET name = ?, password_hash = ?, roleID = ? WHERE email = ?");
    $update->bind_param('ssis', $admin_name, $admin_password, $admin_role, $admin_email);
    if ($update->execute()) {
        echo "管理者アカウントを更新しました<br>";
    } else {
        echo "管理者アカウントの更新に失敗しました: " . $connection->error . "<br>";
    }
} else {
    // 新しい管理者アカウントを作成
    $insert = $connection->prepare("INSERT INTO staff (name, email, password_hash, roleID) VALUES (?, ?, ?, ?)");
    $insert->bind_param('sssi', $admin_name, $admin_email, $admin_password, $admin_role);
    if ($insert->execute()) {
        echo "管理者アカウントを作成しました<br>";
    } else {
        echo "管理者アカウントの作成に失敗しました: " . $connection->error . "<br>";
    }
}

// マネージャーアカウントの作成または更新
$check_manager = $connection->prepare("SELECT staffID FROM staff WHERE email = ?");
$check_manager->bind_param('s', $manager_email);
$check_manager->execute();
$result = $check_manager->get_result();

if ($result->num_rows > 0) {
    // 既存のマネージャーアカウントを更新
    $update = $connection->prepare("UPDATE staff SET name = ?, password_hash = ?, roleID = ? WHERE email = ?");
    $update->bind_param('ssis', $manager_name, $manager_password, $manager_role, $manager_email);
    if ($update->execute()) {
        echo "マネージャーアカウントを更新しました<br>";
    } else {
        echo "マネージャーアカウントの更新に失敗しました: " . $connection->error . "<br>";
    }
} else {
    // 新しいマネージャーアカウントを作成
    $insert = $connection->prepare("INSERT INTO staff (name, email, password_hash, roleID) VALUES (?, ?, ?, ?)");
    $insert->bind_param('sssi', $manager_name, $manager_email, $manager_password, $manager_role);
    if ($insert->execute()) {
        echo "マネージャーアカウントを作成しました<br>";
    } else {
        echo "マネージャーアカウントの作成に失敗しました: " . $connection->error . "<br>";
    }
}

// テーブル構造の表示
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "<br>現在のスタッフテーブル構造:<br>";
    echo "<pre>";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
}

// アカウント情報の表示
$result = $connection->query("SELECT staffID, name, email, roleID FROM staff WHERE email IN ('admin@anthonyfastfood.com', 'manager@anthonyfastfood.com')");
if ($result) {
    echo "<br>作成されたアカウントの詳細:<br>";
    echo "<pre>";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
}

echo "<br>管理者アカウントのログイン情報:<br>";
echo "メールアドレス: admin@anthonyfastfood.com<br>";
echo "パスワード: Admin@123<br>";

echo "<br>マネージャーアカウントのログイン情報:<br>";
echo "メールアドレス: manager@anthonyfastfood.com<br>";
echo "パスワード: Manager@123<br>";
?> 