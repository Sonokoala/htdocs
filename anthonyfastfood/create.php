<?php
require_once "part2/db.php";
require_once "part2/auth.php";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$staffID = $name = $email = $mob = $address = "";
$errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffID = $_POST["staffid"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mob = $_POST["mob"];
    $address = $_POST["address"];

    do {
        if (empty($staffID) || empty($name) || empty($email) || empty($mob) || empty($address)) {
            $errorMessage = "All the fields are required";
            break;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format";
            break;
        }
        $stmt = $connection->prepare("INSERT INTO staff (staffID, name, address, email, mob) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            $errorMessage = "Prepare failed: " . $connection->error;
            break;
        }
        $stmt->bind_param("sssss", $staffID, $name, $address, $email, $mob);
        $executeResult = $stmt->execute();
        if (!$executeResult) {
            $errorMessage = "Execute failed: " . $stmt->error;
            $stmt->close();
            break;
        }
        $stmt->close();
        $staffID = $name = $email = $mob = $address = "";
        $successMessage = "Client added successfully";
        header("Location: /anthonyfastfood/index.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Fast Food</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
    function validateForm() {
        const staffID = document.getElementsByName("staffid")[0].value.trim();
        const name = document.getElementsByName("name")[0].value.trim();
        const email = document.getElementsByName("email")[0].value.trim();
        const mob = document.getElementsByName("mob")[0].value.trim();
        const address = document.getElementsByName("address")[0].value.trim();

        if (!/^\d+$/.test(staffID)) {
            alert("Staff ID must contain only numbers");
            return false;
        }
        if (name.length < 2) {
            alert("Name must be at least 2 characters long");
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert("Please enter a valid email address");
            return false;
        }
        if (!/^\d+$/.test(mob)) {
            alert("Mobile number must contain only numbers");
            return false;
        }
        if (address.length < 5) {
            alert("Address must be at least 5 characters long");
            return false;
        }
        return true;
    }
</script>
<style>
/* (ここにナビCSSは省略せず貼り付けてOK) */
    .navbar {
        display: flex; align-items: center; background: #f5f5f5; padding: 0 10px; border-radius: 5px;
        margin-bottom: 32px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .nav-logo {
        font-weight: bold; margin-right: 30px; font-size: 1.1em; color: #222;
    }
    .nav-list {
        display: flex; list-style: none; padding: 0; margin: 0; flex-grow: 1;
    }
    .nav-item {position: relative;}
    .nav-link, .dropbtn {
        display: block; padding: 16px 18px; color: #555; text-decoration: none;
        background: none; border: none; cursor: pointer; font-size: 1em;
    }
    .nav-link:hover, .dropbtn:hover {background: #e1e1e1; color: #111;}
    .dropdown-content {
        display: none; position: absolute; min-width: 160px;
        z-index: 1; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        border-radius: 0 0 8px 8px; padding: 8px 0;
    }
    .dropdown-content a {
        color: #333; padding: 10px 20px; text-decoration: none; display: block;
    }
    .dropdown-content a:hover {background: #f0f0f0;}
    .nav-item:hover .dropdown-content {display: block;}
    .logout-btn {
        margin-left: auto;
        padding: 12px 34px;
        background: #fff;
        border: 2px solid #333;
        border-radius: 4px;
        font-weight: bold; color: #222; cursor: pointer;
        text-decoration: none;
    }
    .logout-btn:hover {background: #333; color: #fff;}
</style>
</head>
<body>
<?php include "part2/navbar.php"; ?>

<div class="container my-5">
    <h2>New Client</h2>

    <?php if (!empty($errorMessage)): ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong><?php echo $errorMessage; ?></strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    <?php endif; ?>

    <form action="" method="post" onsubmit="return validateForm()">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">ID</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="staffid" value="<?php echo htmlspecialchars($staffID); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Mobile</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="mob" value="<?php echo htmlspecialchars($mob); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/anthonyfastfood/index.php" role="button">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
