<?php
require_once "db.php";

// Debug: Show tables and staff table structure
if (isset($_GET['debug'])) {
    echo "<pre>";
    
    // Get specific staff record
    $email = 'manager@anthonyfastfood.com';
    $stmt = $connection->prepare("SELECT staffID, name, email, password_hash, roleID FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
        echo "Staff Record for $email:\n";
        echo "staffID: " . $staff['staffID'] . "\n";
        echo "name: " . $staff['name'] . "\n"; 
        echo "email: " . $staff['email'] . "\n";
        echo "password_hash: " . $staff['password_hash'] . "\n";
        echo "roleID: " . $staff['roleID'] . "\n";
        
        // Verify password
        $inputPassword = 'Manager@123';
        $isValid = password_verify($inputPassword, $staff['password_hash']);
        echo "\nPassword Verification:\n";
        echo "Input: $inputPassword\n";
        echo "Stored Hash: " . $staff['password_hash'] . "\n";
        echo "Match: " . ($isValid ? "YES" : "NO") . "\n";
    } else {
        echo "No staff found with email: $email";
    }
    
    echo "</pre>";
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $dateOfBirth = $_POST['dateOfBirth'] ?? '';
        $mob = $_POST['mob'] ?? '';
        $role = $_POST['role'] ?? 'staff';

        // Convert role to roleID
        $roleID = $role === 'manager' ? 2 : 3; // 2=manager, 3=staff

        if (empty($email) || empty($password) || empty($name) || empty($address) || empty($dateOfBirth) || empty($mob)) {
            $error = 'All fields are required';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $connection->prepare("INSERT INTO staff (email, password_hash, name, address, dateOfBirth, mob, roleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $email, $hashedPassword, $name, $address, $dateOfBirth, $mob, $roleID);
        
        if ($stmt->execute()) {
            $success = 'Staff registered successfully';
        } else {
            $error = 'Registration failed: ' . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2>Register New Staff</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="dateOfBirth" class="form-label">Date of Birth</label>
            <input type="text" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="YYYY-MM-DD" required readonly>
        </div>
        <script>
            $(function() {
                // Initialize jQuery UI Datepicker with English locale
                $("#dateOfBirth").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                    showMonthAfterYear: false,
                    dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                });
                
                // Set placeholder text
                $("#dateOfBirth").attr("placeholder", "YYYY-MM-DD");
            });
        </script>
        <div class="mb-3">
            <label for="mob" class="form-label">Mobile Number</label>
            <input type="tel" class="form-control" id="mob" name="mob" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="/anthonyfastfood/index.php" class="btn btn-secondary">Back to Home</a>
    </form>
</div>
</body>
</html>
