<?php
require_once 'part2/auth.php';
require_once 'part2/db.php';

// Check if staff is logged in
if (!isset($_SESSION['staffID'])) {
    header('Location: login.php');
    exit();
}

$staffID = $_SESSION['staffID'];

// Get staff name
$staffName = '';
$staffRes = $connection->query("SELECT name FROM staff WHERE staffID = $staffID");
if ($staffRes && ($row = $staffRes->fetch_assoc())) {
    $staffName = $row['name'];
}

// Get data from roster+rosterrole+role JOIN
$sql = "
SELECT 
    r.rosterID,
    r.dateTimeFrom as start,
    r.dateTimeTo as end,
    role.roleID,
    role.name AS staffRole,
    s.staffID,
    s.name
FROM 
    staff s
INNER JOIN role ON s.roleID = role.roleID
CROSS JOIN roster r
LEFT JOIN rosterrole rr ON r.rosterID = rr.roasterID AND rr.roleID = s.roleID
WHERE
    s.staffID = $staffID
ORDER BY
    r.dateTimeFrom
";
$rosterRes = $connection->query($sql);

// Get staff availability data
$sql = "SELECT 
            s.staffID,
            s.name,
            s.roleID,
            r.rosterID,
            COALESCE(a.start_time, r.dateTimeFrom) as start_time,
            COALESCE(a.end_time, r.dateTimeTo) as end_time
        FROM staff s
        CROSS JOIN roster r
        LEFT JOIN availability a ON s.staffID = a.staffID AND r.rosterID = a.rosterID
        ORDER BY s.staffID, r.dateTimeFrom";

$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Staff Availability</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Navbar styling */
.navbar {
    margin-bottom: 32px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.table th, .table td {
    vertical-align: middle;
}
.update-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 4px;
    cursor: pointer;
}
.form-check-input {
    width: 20px;
    height: 20px;
}
.table-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
}
</style>
</head>
<body>
<!-- Start of navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navigation Bar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/anthonyfastfood/home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown">
                        Product Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/anthonyfastfood/create.php">Add Product</a></li>
                        <li><a class="dropdown-item" href="/anthonyfastfood/edit.php">Edit Product</a></li>
                        <li><a class="dropdown-item" href="/anthonyfastfood/delete.php">Remove Product</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="staffDropdown" role="button" data-bs-toggle="dropdown">
                        Staff Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/anthonyfastfood/part2/staff_create.php">Add Staff</a></li>
                        <li><a class="dropdown-item" href="/anthonyfastfood/part2/staff_update.php">Edit Staff</a></li>
                        <li><a class="dropdown-item" href="/anthonyfastfood/part2/staff_delete.php">Remove Staff</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="availabilityDropdown" role="button" data-bs-toggle="dropdown">
                        Availability
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/anthonyfastfood/availability.php">View Availability</a></li>
                        <li><a class="dropdown-item" href="/anthonyfastfood/availUpdate.php">Update Availability</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
                <a class="btn btn-outline-dark" href="/anthonyfastfood/logout.php">Log Out</a>
            </div>
        </div>
    </div>
</nav>
<!-- End of navigation bar -->
<div class="container my-5">
    <div class="table-container">
        <h4 class="mb-4">Specify when you are available to work</h4>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <form action="availUpdate.php" method="POST">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" class="update-btn">Update</button>
                        </th>
                        <th>StaffID</th>
                        <th>Name</th>
                        <th>RoleID</th>
                        <th>RosterID</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" 
                                       name="available_rosters[]" 
                                       value="<?= $row['rosterID'] ?>">
                            </td>
                            <td><?= htmlspecialchars($row['staffID']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['roleID']) ?></td>
                            <td><?= htmlspecialchars($row['rosterID']) ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($row['start_time'])) ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($row['end_time'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize all Bootstrap components
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
});
</script>
</body>
</html>
<?php $connection->close(); ?>
