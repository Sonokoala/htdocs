<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Anthony Fast Food</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container my-5">
    <div class="alert alert-info">
        <h2>Welcome to Anthony Fast Food</h2>
        <?php if (!isset($_SESSION['loggedin'])): ?>
            <p>Please <a href="login.php" class="alert-link">login</a> to access staff management.</p>
        <?php else: ?>
            <p>Welcome back! Use the navigation menu to manage staff and availability.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
