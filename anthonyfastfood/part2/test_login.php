<?php
require_once 'db.php';
require_once 'debug.php';

echo "<h2>ログイン機能テスト</h2>";

// データベース接続テスト
echo "<h3>1. データベース接続テスト</h3>";
if (test_db_connection($connection)) {
    echo "✅ データベース接続成功<br>";
} else {
    echo "❌ データベース接続失敗<br>";
}

// スタッフテーブルの構造確認
echo "<h3>2. スタッフテーブル構造確認</h3>";
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "テーブル構造:<br><pre>";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
} else {
    echo "❌ テーブル構造の取得に失敗: " . $connection->error . "<br>";
}

// テストアカウントでのログインテスト
echo "<h3>3. ログインテスト</h3>";

// テストケース
$test_cases = [
    [
        'email' => 'admin@anthonyfastfood.com',
        'password' => 'Admin@123',
        'expected_role' => 1
    ],
    [
        'email' => 'manager@anthonyfastfood.com',
        'password' => 'Manager@123',
        'expected_role' => 2
    ],
    [
        'email' => 'staff1@example.com',
        'password' => 'Staff123!',
        'expected_role' => 3
    ]
];

foreach ($test_cases as $test) {
    echo "<br>テストケース: " . $test['email'] . "<br>";
    
    $stmt = $connection->prepare("SELECT staffID, name, email, password_hash, roleID FROM staff WHERE email = ?");
    $stmt->bind_param('s', $test['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($test['password'], $user['password_hash'])) {
            echo "✅ ログイン成功<br>";
            echo "- ユーザー名: " . $user['name'] . "<br>";
            echo "- 権限レベル: " . $user['roleID'] . "<br>";
            if ($user['roleID'] === $test['expected_role']) {
                echo "✅ 権限レベル確認OK<br>";
            } else {
                echo "❌ 権限レベルが期待値と異なります（期待値: {$test['expected_role']}, 実際: {$user['roleID']}）<br>";
            }
        } else {
            echo "❌ パスワード不一致<br>";
        }
    } else {
        echo "❌ ユーザーが見つかりません<br>";
    }
}

// セッション動作確認
echo "<h3>4. セッション動作確認</h3>";
session_start();
$_SESSION['test_value'] = 'テストセッション';
if (isset($_SESSION['test_value'])) {
    echo "✅ セッション動作確認OK<br>";
    echo "セッションID: " . session_id() . "<br>";
} else {
    echo "❌ セッション動作確認失敗<br>";
}

// エラーログの確認
echo "<h3>5. エラーログの確認</h3>";
$log_file = __DIR__ . '/error.log';
if (file_exists($log_file)) {
    echo "最新のエラーログ:<br><pre>";
    $logs = file_get_contents($log_file);
    echo htmlspecialchars(substr($logs, -1000)); // 最後の1000文字を表示
    echo "</pre>";
} else {
    echo "エラーログファイルが見つかりません<br>";
}
?> 