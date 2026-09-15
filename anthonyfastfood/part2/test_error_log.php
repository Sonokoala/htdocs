<?php
// Character encoding settings
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
ini_set('default_charset', 'UTF-8');

// Error log file settings
$logFile = __DIR__ . '/../logs/debug.log';

// Write to log file with UTF-8 encoding
file_put_contents($logFile, "=== Log Test Started " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);

// Error settings
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', $logFile);
error_reporting(E_ALL);

// Set log file permissions
chmod($logFile, 0666);

// Write test message
error_log("This is a test message");

// Generate an error
$undefined_variable;
trigger_error("This is an intentional test error", E_USER_WARNING);

// Display result
header('Content-Type: text/html; charset=UTF-8');
echo "Test completed. Please check the log file: " . $logFile;
?> 