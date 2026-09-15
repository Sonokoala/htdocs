<?php
require_once 'debug.php';

// テスト用のデバッグメッセージを出力
debug_log("これはテストメッセージです");

// エラーをテスト
trigger_error("これはテストエラーです", E_USER_WARNING);

// 例外をテスト
try {
    throw new Exception("これはテスト例外です");
} catch (Exception $e) {
    debug_log("例外をキャッチしました", [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}

echo "テスト完了。ログファイルを確認してください。";
?> 