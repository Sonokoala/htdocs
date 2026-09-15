<?php
require_once 'db.php';
require_once 'debug.php';

// Get table structure
$result = $connection->query("DESCRIBE staff");
if ($result) {
    echo "=== Staff Table Structure ===\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Error getting table structure: " . $connection->error;
}

// Check sample data
$result = $connection->query("SELECT * FROM staff LIMIT 1");
if ($result) {
    echo "\n=== Sample Staff Data ===\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Error getting sample data: " . $connection->error;
}
?> 