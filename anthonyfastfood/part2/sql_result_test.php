<?php
require_once 'header.php';
require_once 'sql_result.php';

// Initialize SQL Result handler
$sqlResult = new SQLResult($connection);

// Test INSERT
$insert_result = $sqlResult->insert(
    "INSERT INTO staff (name, address, dateOfBirth, email, mob, passwordHash, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)",
    ["Test Staff", "123 Test St", "1990-01-01", "test@test.com", "1234567890", password_hash("test123", PASSWORD_DEFAULT), 1],
    "ssssssi"
);

// Display INSERT result
echo "<h3>INSERT Test Result</h3>";
echo $sqlResult->displayResult("Staff Insert Operation");

// Test UPDATE
$update_result = $sqlResult->update(
    "UPDATE staff SET name = ? WHERE email = ?",
    ["Updated Test Staff", "test@test.com"],
    "ss"
);

// Display UPDATE result
echo "<h3>UPDATE Test Result</h3>";
echo $sqlResult->displayResult("Staff Update Operation");

// Test SELECT
$select_result = $sqlResult->select(
    "SELECT * FROM staff WHERE email = ?",
    ["test@test.com"],
    "s"
);

// Display SELECT result
echo "<h3>SELECT Test Result</h3>";
if ($select_result !== false) {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr>";
    foreach ($select_result[0] as $key => $value) {
        echo "<th>" . htmlspecialchars($key) . "</th>";
    }
    echo "</tr></thead><tbody>";
    foreach ($select_result as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}

// Test DELETE
$delete_result = $sqlResult->delete(
    "DELETE FROM staff WHERE email = ?",
    ["test@test.com"],
    "s"
);

// Display DELETE result
echo "<h3>DELETE Test Result</h3>";
echo $sqlResult->displayResult("Staff Delete Operation");

require_once 'footer.php';
?> 