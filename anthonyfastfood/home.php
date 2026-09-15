<?php
session_start();
require_once 'part2/db.php';

// デバッグ情報
error_log("Home.php accessed. Session: " . print_r($_SESSION, true));

// 認証チェック
if (!isset($_SESSION['staffID'])) {
    error_log("Authentication failed in home.php - redirecting to login");
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Anthony's Fast Food | Login</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #fafbfc;
}
.main-wrap {
    display: flex;
    min-height: 100vh;
}
.sidebar {
    width: 220px;
    background: #f7f7f7;
    border-right: 1.5px solid #e0e0e0;
    padding: 30px 18px 15px 18px;
    min-height: 100vh;
}
.sidebar h2 {
    font-size: 1.25em;
    margin-bottom: 2.1em;
    font-weight: bold;
    color: #333;
}
.sidebar .nav {
    flex-direction: column;
}
.sidebar .nav-link,
.sidebar .dropdown-toggle {
    color: #222;
    margin-bottom: 2px;
    text-align: left;
}
.sidebar .nav-link.active,
.sidebar .btn-primary {
    background-color: #0d6efd;
    color: #fff;
    border-radius: 12px;
}
.sidebar .nav-link:hover, .sidebar .dropdown-item:hover {
    background: #e4f0ff;
}
.sidebar .btn-primary {
    margin-top: 2em;
    width: 140px;
}
.content {
    flex: 1;
    padding: 42px 42px 0 42px;
    display: flex;
    flex-direction: column;
}
.info-area {
    max-width: 650px;
    margin-bottom: 52px;
}
.login-area {
    max-width: 400px;
    margin: 42px auto 0 auto;
}
.footer {
    text-align: center;
    padding: 12px 0 10px;
    background: #f7f7f7;
    font-size: 0.95em;
    color: #888;
    margin-top: auto;
    border-top: 1px solid #e4e4e4;
}
@media (max-width: 900px) {
    .main-wrap {flex-direction: column;}
    .sidebar {width:100%;min-height:unset;}
    .content {padding:22px;}
}
</style>
</head>
<body>
<div class="main-wrap">
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <h2>Navbar</h2>
        <ul class="nav">
            <li class="nav-item mb-1">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item dropdown mb-1">
              <a class="nav-link dropdown-toggle" href="#" id="staffDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Manage Staff
              </a>
              <ul class="dropdown-menu" aria-labelledby="staffDropdown">
                <li><a class="dropdown-item" href="../create.php">Create</a></li>
                <li><a class="dropdown-item" href="../edit.php">Edit</a></li>
                <li><a class="dropdown-item" href="../delete.php">Delete</a></li>
              </ul>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link" href="../availability.php">Availability</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link" href="../logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <!-- Main Content -->
    <div class="content">
        <h1 class="text-center mb-4" style="font-size: 2rem; font-weight: bold;">Anthony's First Food Home Staff Home Page</h1>
        <div class="info-area">
            <h3 class="mb-3">Challenges and Solutions: Implementing a New Business Application</h3>
            <p>
            Anthony's Fast-Food Restaurant, located in the Hills district, has been facing several operational challenges, including:
            </p>
            <ul>
                <li>Inventory management difficulties leading to stock shortages or wastage</li>
                <li>Complex staff scheduling affecting labor efficiency</li>
                <li>Maintaining consistent quality in customer service</li>
            </ul>
            <p>
            To address these challenges and boost overall operational efficiency and competitiveness, the management decided to implement a new business application. This application aims to:
            </p>
            <ul>
                <li>Automate and optimize inventory tracking to reduce waste and ensure availability</li>
                <li>Streamline staff scheduling for better labor resource management</li>
                <li>Improve customer service through real-time feedback systems and better workflow management</li>
            </ul>
            <p>
            By leveraging technology, Anthony's fast food expects to enhance performance, reduce operational costs, and provide superior customer experiences, reinforcing its competitive advantage in the Hills district market.
            </p>
        </div>
       
        <div class="footer">
            &copy; <?= date('Y') ?> Anthony’s First Fast Food Restaurant. All rights reserved.
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
