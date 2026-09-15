<?php
require_once "part2/db.php";
require_once "part2/auth.php";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

$staffID = $name = $email = $mob = $address = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // パラメータがない or 空の場合はトップに戻す
    if (empty($_GET["staffID"])) {
        header("Location: /anthonyfastfood/index.php");
        exit;
    }
    $staffID = $_GET["staffID"];
    $stmt = $connection->prepare("SELECT * FROM staff WHERE staffID = ?");
    $stmt->bind_param("s", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (!$row) {
        header("Location: /anthonyfastfood/index.php");
        exit;
    }
    $name = $row["name"];
    $email = $row["email"];
    $mob = $row["mob"];
    $address = $row["address"];
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $_POST["staffID"];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $mob = trim($_POST["mob"]);
    $address = trim($_POST["address"]);
    // バリデーション
    if ($name === "" || $email === "" || $mob === "" || $address === "") {
        $errorMessage = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } else {
        $stmt = $connection->prepare("UPDATE staff SET name=?, email=?, mob=?, address=? WHERE staffID=?");
        $stmt->bind_param("sssss", $name, $email, $mob, $address, $staffID);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Staff member updated successfully.";
            $stmt->close();
            $connection->close();
            header("Location: /anthonyfastfood/index.php");
            exit;
        } else {
            $errorMessage = "Database error: " . $stmt->error;
            $stmt->close();
        }
    }
}
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Staff Member</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
    function validateForm() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const mob = document.getElementById('mob').value.trim();
        const address = document.getElementById('address').value.trim();

        if (name.length < 2) {
            alert('Name must be at least 2 characters long');
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert('Please enter a valid email address');
            return false;
        }
        if (!/^\d+$/.test(mob)) {
            alert('Mobile number must contain only numbers');
            return false;
        }
        if (address.length < 5) {
            alert('Address must be at least 5 characters long');
            return false;
        }
        return true;
    }
</script>
</head>
<body>
<?php include "part2/navbar.php"; ?>
<div class="container my-5">
<h2>Edit Staff Member</h2>
<?php if ($errorMessage): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($errorMessage) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<form method="post" onsubmit="return validateForm()">
    <input type="hidden" name="staffID" value="<?= htmlspecialchars($staffID) ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
    </div>
    <div class="mb-3">
        <label for="mob" class="form-label">Mobile</label>
        <input type="text" id="mob" name="mob" class="form-control" value="<?= htmlspecialchars($mob) ?>" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="/anthonyfastfood/index.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
