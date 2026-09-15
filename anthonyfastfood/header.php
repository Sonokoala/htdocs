<?php
session_start();
$_SESSION = [];
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logged Out</title>
  <meta http-equiv="refresh" content="2;url=login.php">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="alert alert-info text-center">
    <h4>You have been logged out.</h4>
    <p>Redirecting to login page...</p>
  </div>
</body>
</html>