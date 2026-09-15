<?php
session_start();

// Check if user is logged in and has supervisor/manager role
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['role']) || 
    ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) { // Assuming 1 = Manager, 2 = Supervisor
    header('Location: login.php');
    exit;
}

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get all rosters for the next 2 weeks
$sql = "
SELECT 
    r.rosterID,
    r.dateTimeFrom,
    r.dateTimeTo,
    COUNT(DISTINCT CASE WHEN a.staffID IS NOT NULL THEN a.staffID END) as available_staff_count,
    GROUP_CONCAT(DISTINCT CONCAT(s.name, ' (', role.name, '): ', 
        TIME_FORMAT(a.start_time, '%h:%i %p'), ' - ', 
        TIME_FORMAT(a.end_time, '%h:%i %p')
    ) ORDER BY s.name SEPARATOR '<br>') as available_staff,
    role.name as role_name,
    COUNT(DISTINCT s2.staffID) as total_staff_in_role
FROM 
    roster r
    CROSS JOIN role
    LEFT JOIN availability a ON r.rosterID = a.rosterID
    LEFT JOIN staff s ON a.staffID = s.staffID
    LEFT JOIN staff s2 ON s2.roleID = role.roleID
WHERE 
    r.dateTimeFrom >= CURDATE() 
    AND r.dateTimeFrom <= DATE_ADD(CURDATE(), INTERVAL 2 WEEK)
    AND (
        a.staffID IS NULL OR 
        (a.start_time IS NOT NULL AND a.end_time IS NOT NULL)
    )
GROUP BY 
    r.rosterID, role.roleID
ORDER BY 
    r.dateTimeFrom, role.name
";

$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Availability Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .availability-good { background-color: #d4edda; }
        .availability-warning { background-color: #fff3cd; }
        .availability-critical { background-color: #f8d7da; }
        .staff-list {
            font-size: 0.9em;
            max-width: 300px;
            word-wrap: break-word;
        }
        .summary-card {
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .date-header {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container my-4">
    <h2 class="mb-4">Staff Availability Summary</h2>
    
    <?php
    $current_date = '';
    while ($row = $result->fetch_assoc()):
        $date = date('Y-m-d', strtotime($row['dateTimeFrom']));
        
        // Calculate availability percentage
        $availability_percentage = $row['total_staff_in_role'] > 0 
            ? ($row['available_staff_count'] / $row['total_staff_in_role']) * 100 
            : 0;
        
        // Determine status class
        $status_class = '';
        if ($availability_percentage >= 75) {
            $status_class = 'availability-good';
        } elseif ($availability_percentage >= 50) {
            $status_class = 'availability-warning';
        } else {
            $status_class = 'availability-critical';
        }

        // Show date header if it's a new date
        if ($current_date != $date):
            if ($current_date != '') echo '</div>'; // Close previous card-group
            $current_date = $date;
    ?>
        <div class="date-header">
            <h4><?= date('l, F j, Y', strtotime($date)) ?></h4>
        </div>
        <div class="card-group">
    <?php endif; ?>

        <div class="card summary-card <?= $status_class ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['role_name']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <?= date('g:i A', strtotime($row['dateTimeFrom'])) ?> - 
                    <?= date('g:i A', strtotime($row['dateTimeTo'])) ?>
                </h6>
                <p class="card-text">
                    Available: <?= $row['available_staff_count'] ?> / <?= $row['total_staff_in_role'] ?> staff
                    (<?= round($availability_percentage) ?>%)
                </p>
                <div class="staff-list">
                    <small>
                        <strong>Available Staff:</strong><br>
                        <?= $row['available_staff'] ? htmlspecialchars($row['available_staff']) : 'None available' ?>
                    </small>
                </div>
            </div>
        </div>

    <?php endwhile; ?>
    </div> <!-- Close last card-group -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $connection->close(); ?> 