<?php
// Character encoding settings
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
ini_set('default_charset', 'UTF-8');

// Debug mode settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Custom error log file settings
ini_set('log_errors', 1);
$log_dir = __DIR__ . '/logs';
$log_file = $log_dir . '/debug.log';

// Check and create log file
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0777, true);
}

if (!file_exists($log_file)) {
    file_put_contents($log_file, '');
    chmod($log_file, 0666);
}

ini_set('error_log', $log_file);

// Initialize log
error_log("=== Debug Log Initialized " . date('Y-m-d H:i:s') . " ===\n");

// Error handler setup
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $error_message = "Error [$errno]: $errstr in $errfile on line $errline";
    debug_log($error_message);
    return false;
});

// Exception handler setup
set_exception_handler(function($exception) {
    $error_message = "Uncaught Exception: " . $exception->getMessage() . 
                    "\nFile: " . $exception->getFile() . 
                    "\nLine: " . $exception->getLine() . 
                    "\nTrace: " . $exception->getTraceAsString();
    debug_log($error_message);
});

// Debug logging function
function debug_log($message, $data = null) {
    $log_message = date('Y-m-d H:i:s') . ' - ' . $message;
    if ($data !== null) {
        $log_message .= "\nData: " . print_r($data, true);
    }
    error_log($log_message);
}

// SQL query debugging function
function debug_query($query, $params = []) {
    $message = "SQL Query: " . $query;
    if (!empty($params)) {
        $message .= "\nParameters: " . print_r($params, true);
    }
    debug_log($message);
}

// Session debugging function
function debug_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    debug_log("Session Data:", $_SESSION);
}

// Request debugging function
function debug_request() {
    $request_data = [
        'GET' => $_GET,
        'POST' => $_POST,
        'SERVER' => [
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? '',
            'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? '',
            'HTTP_REFERER' => $_SERVER['HTTP_REFERER'] ?? ''
        ]
    ];
    debug_log("Request Data:", $request_data);
}

// Database connection test function
function test_db_connection($connection) {
    try {
        if ($connection->ping()) {
            debug_log("Database connection successful");
            return true;
        } else {
            debug_log("Database connection failed: " . $connection->error);
            return false;
        }
    } catch (Exception $e) {
        debug_log("Database connection error: " . $e->getMessage());
        return false;
    }
}

// File upload debugging function
function debug_file_upload() {
    if (!empty($_FILES)) {
        debug_log("File Upload Data:", $_FILES);
    }
}

// Variable type and data structure debugging function
function debug_var($var, $name = 'Variable') {
    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    debug_log("$name Debug:", $output);
}

// Log PHP configuration
debug_log("PHP Configuration", [
    'error_reporting' => error_reporting(),
    'log_errors' => ini_get('log_errors'),
    'error_log' => ini_get('error_log'),
    'display_errors' => ini_get('display_errors'),
    'default_charset' => ini_get('default_charset'),
    'internal_encoding' => mb_internal_encoding()
]);
?> 