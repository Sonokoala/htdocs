<?php
require_once 'db.php';
require_once 'debug.php';

// テスト用スタッフアカウントの設定
$staff_email = 'staff1@example.com';
$staff_password = 'Staff123!'; // 新しいパスワード
$password_hash = password_hash($staff_password, PASSWORD_DEFAULT);

// パスワードの更新
$stmt = $connection->prepare("UPDATE staff SET password_hash = ? WHERE email = ?");
$stmt->bind_param('ss', $password_hash, $staff_email);

if ($stmt->execute()) {
    echo "テストアカウントのパスワードを更新しました<br>";
    echo "<br>テストアカウント（一般スタッフ）のログイン情報:<br>";
    echo "メールアドレス: " . $staff_email . "<br>";
    echo "パスワード: " . $staff_password . "<br>";
    
    // アカウント情報の確認
    $result = $connection->query("SELECT staffID, name, email, roleID FROM staff WHERE email = '$staff_email'");
    if ($result && $row = $result->fetch_assoc()) {
        echo "<br>アカウントの詳細:<br>";
        echo "スタッフID: " . $row['staffID'] . "<br>";
        echo "名前: " . $row['name'] . "<br>";
        echo "権限レベル: " . $row['roleID'] . " (一般スタッフ)<br>";
    }
} else {
    echo "エラー: パスワードの更新に失敗しました。<br>";
    echo $connection->error;
}
?> 