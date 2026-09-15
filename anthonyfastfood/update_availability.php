<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['shifts']) && is_array($_POST['shifts'])) {
        foreach ($_POST['shifts'] as $shiftId) {
            $staffId = $_POST['staff_id'][$shiftId];
            $rosterId = $_POST['roster_id'][$shiftId];
            $startTime = $_POST['start_time'][$shiftId];
            $endTime = $_POST['end_time'][$shiftId];
            
            // Update the availability in the database
            $stmt = $connection->prepare("UPDATE availability SET start_time = ?, end_time = ? WHERE staff_id = ? AND roster_id = ?");
            $stmt->bind_param("ssii", $startTime, $endTime, $staffId, $rosterId);
            $stmt->execute();
            $stmt->close();
        }
        
        $_SESSION['success_message'] = "Availability has been updated successfully!";
        header("Location: availability.php");
        exit();
    }
}

// Get staff availabilities
$sql = "
SELECT 
    a.staff_id,
    a.roster_id,
    a.start_time,
    a.end_time,
    s.name as staff_name,
    r.date as roster_date
FROM 
    availability a
    JOIN staff s ON a.staff_id = s.staffID
    JOIN roster r ON a.roster_id = r.rosterID
ORDER BY 
    r.date, a.start_time
";

$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Staff Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-check {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">FastFood Management</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="availability.php">View Availability</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Update Staff Availability</h2>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form method="POST" action="" id="availabilityForm">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Staff Name</th>
                            <th>Roster Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="shifts[]" value="<?= $row['staff_id'] . '_' . $row['roster_id'] ?>">
                                        <input type="hidden" name="staff_id[<?= $row['staff_id'] . '_' . $row['roster_id'] ?>]" value="<?= $row['staff_id'] ?>">
                                        <input type="hidden" name="roster_id[<?= $row['staff_id'] . '_' . $row['roster_id'] ?>]" value="<?= $row['roster_id'] ?>">
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['staff_name']) ?></td>
                                <td><?= htmlspecialchars($row['roster_date']) ?></td>
                                <td>
                                    <input type="datetime-local" class="form-control" 
                                           name="start_time[<?= $row['staff_id'] . '_' . $row['roster_id'] ?>]" 
                                           value="<?= date('Y-m-d\TH:i', strtotime($row['start_time'])) ?>">
                                </td>
                                <td>
                                    <input type="datetime-local" class="form-control" 
                                           name="end_time[<?= $row['staff_id'] . '_' . $row['roster_id'] ?>]" 
                                           value="<?= date('Y-m-d\TH:i', strtotime($row['end_time'])) ?>">
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Availability</button>
                <a href="availability.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('input[name="shifts[]"]:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one shift to update');
                return false;
            }
            
            let hasError = false;
            checkedBoxes.forEach(box => {
                const id = box.value;
                const startTime = document.querySelector(`input[name="start_time[${id}]"]`).value;
                const endTime = document.querySelector(`input[name="end_time[${id}]"]`).value;
                
                if (!startTime || !endTime) {
                    hasError = true;
                    alert('Please enter both start and end times for selected shifts');
                    e.preventDefault();
                    return;
                }
                
                if (new Date(startTime) >= new Date(endTime)) {
                    hasError = true;
                    alert('End time must be after start time');
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
</body>
</html>
<?php $connection->close(); ?> 