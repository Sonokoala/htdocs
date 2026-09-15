<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <span class="nav-logo">Navigation Bar</span>
    <ul class="nav-list">
        <li class="nav-item">
            <a class="nav-link" href="/anthonyfastfood/index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
            <button class="dropbtn">Manage Staff ▼</button>
            <div class="dropdown-content">
                <a href="/anthonyfastfood/staff.php">Staff List</a>
                <a href="/anthonyfastfood/create.php">Create Staff</a>
                <a href="/anthonyfastfood/part2/register_staff.php">Register New Staff</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <button class="dropbtn">Availability ▼</button>
            <div class="dropdown-content">
                <a href="/anthonyfastfood/availability.php">View Availability</a>
                <a href="/anthonyfastfood/availUpdate.php">Update Availability</a>
                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)): ?>
                <a href="/anthonyfastfood/staff_availability_summary.php">Availability Summary</a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
    <a class="logout-btn" href="/anthonyfastfood/logout.php">Log Out</a>
</nav> 