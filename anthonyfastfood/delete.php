<?php
require_once "part2/db.php";
require_once "part2/auth.php";
// create connection
$connection = new mysqli($servername, $username, $password, $database);

// check connection
if ($connection->connect_error) {
    showErrorAndExit("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET["staffID"])) {
    showErrorAndExit("Staff ID not provided");
}

// 削除確認
if (!isset($_GET['confirm'])) {
    header("Location: index.php?delete_id=" . urlencode($_GET['staffID']));
    exit;
}
$staffID = $_GET["staffID"];

// Prepare statement to prevent SQL injection
$stmt = $connection->prepare("DELETE FROM staff WHERE staffID = ?");
if (!$stmt) {
    showErrorAndExit("Prepare failed: " . $connection->error);
}
if (!$stmt->bind_param("s", $staffID)) {
    showErrorAndExit("Bind failed: " . $stmt->error);
}
if (!$stmt->execute()) {
    showErrorAndExit("Execute failed: " . $stmt->error);
}
$stmt->close();

$connection->close();

header("Location: /anthonyfastfood/index.php");
exit;

// ----- ↓ HTMLエラー表示部分（関数）↓ -----
function showErrorAndExit($msg) {
    include 'header.php'; // header.phpでnavbar.phpのincludeもOK
    echo '<div class="container my-5">';
    echo "<div class='alert alert-danger'><strong>Error: </strong>" . htmlspecialchars($msg) . "</div>";
    echo '</div>';
    include 'footer.php';
    exit;
}
?>
