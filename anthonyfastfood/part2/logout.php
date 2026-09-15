<?php
session_start();

// Security headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

// Clear any stored login attempts
if (isset($_SESSION['email'])) {
    unset($_SESSION['login_attempts'][$_SESSION['email']]);
}

// セッションIDを再生成
session_regenerate_id(true);

// すべてのセッション変数を削除
$_SESSION = array();

// セッションクッキーを削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $params["path"],
        'domain' => $params["domain"],
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// セッションを破棄
session_destroy();

// Clear all other cookies
$cookies = array_keys($_COOKIE);
foreach($cookies as $cookie) {
    setcookie($cookie, '', [
        'expires' => time() - 42000,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// Redirect with a success message
header("Location: login.php?logout=1");
exit;
?>
