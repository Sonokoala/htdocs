<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

// Create connection with error handling
try {
    $connection = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    }
    
    // Set charset to utf8mb4
    if (!$connection->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $connection->error);
    }
    
    // Set timezone
    date_default_timezone_set('Asia/Tokyo');
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}

// Test connection function
function testDatabaseConnection() {
    global $connection;
    try {
        // Get table list
        $result = $connection->query("SHOW TABLES");
        if (!$result) {
            throw new Exception($connection->error);
        }
        
        $tables = [];
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
        
        return count($tables) > 0 
            ? "Database connection successful. Tables found: " . implode(", ", $tables)
            : "Database connected but no tables found";
            
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Direct access test
if (basename($_SERVER['PHP_SELF']) == 'db.php') {
    header('Content-Type: text/plain');
    echo testDatabaseConnection();
    exit;
}
?>
