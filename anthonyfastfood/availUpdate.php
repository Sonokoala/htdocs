<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "fastfood";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) { 
    die("DB connect error: " . $connection->connect_error); 
}

// Get the logged in staff's ID from session
$staffID = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedRosters = $_POST['available_rosters'] ?? [];
    $startTimes = $_POST['start'] ?? [];
    $endTimes = $_POST['end'] ?? [];

    if (!empty($selectedRosters)) {
        foreach($selectedRosters as $rosterID) {
            $rosterID = intval($rosterID);
            $startTime = $startTimes[$rosterID] ?? '';
            $endTime = $endTimes[$rosterID] ?? '';

            if ($startTime && $endTime) {
                $stmt = $connection->prepare("INSERT INTO availability (staffID, rosterID, start_time, end_time) 
                                           VALUES (?, ?, ?, ?) 
                                           ON DUPLICATE KEY UPDATE start_time = VALUES(start_time), end_time = VALUES(end_time)");
                $stmt->bind_param("iiss", $staffID, $rosterID, $startTime, $endTime);
                $stmt->execute();
                $stmt->close();
            }
        }
        $_SESSION['success_message'] = "Availability has been updated successfully!";
    } else {
        $_SESSION['error_message'] = "Please select at least one roster and provide times.";
    }
    header("Location: availability.php");
    exit;
}

// Get staff info
$staffQuery = "SELECT name, roleID FROM staff WHERE staffID = ?";
$stmt = $connection->prepare($staffQuery);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$staffResult = $stmt->get_result();
$staffInfo = $staffResult->fetch_assoc();
$stmt->close();

// Get roster and availability data
$rosterQuery = "SELECT r.rosterID, r.dateTimeFrom, r.dateTimeTo,
                       a.start_time, a.end_time
                FROM roster r
                LEFT JOIN availability a ON r.rosterID = a.rosterID AND a.staffID = ?
                ORDER BY r.dateTimeFrom";
$stmt = $connection->prepare($rosterQuery);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$rosterResult = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Staff Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .update-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
        }
        .form-check-input {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h4 class="mb-4">Update Your Availability</h4>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form method="POST" action="" id="availabilityForm">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                <button type="submit" class="update-btn">Update</button>
                            </th>
                            <th>Staff Name</th>
                            <th>Roster Date</th>
                            <th>Roster Time</th>
                            <th>Your Available Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($roster = $rosterResult->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input" 
                                           name="available_rosters[]" 
                                           value="<?= $roster['rosterID'] ?>">
                                </td>
                                <td><?= htmlspecialchars($staffInfo['name']) ?></td>
                                <td><?= date('Y-m-d', strtotime($roster['dateTimeFrom'])) ?></td>
                                <td>
                                    <?= date('g:i A', strtotime($roster['dateTimeFrom'])) ?> - 
                                    <?= date('g:i A', strtotime($roster['dateTimeTo'])) ?>
                                </td>
                                <td>
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="datetime-local" class="form-control" 
                                                   name="start[<?= $roster['rosterID'] ?>]" 
                                                   value="<?= $roster['start_time'] ? date('Y-m-d\TH:i', strtotime($roster['start_time'])) : date('Y-m-d\TH:i', strtotime($roster['dateTimeFrom'])) ?>">
                                        </div>
                                        <div class="col">
                                            <input type="datetime-local" class="form-control" 
                                                   name="end[<?= $roster['rosterID'] ?>]" 
                                                   value="<?= $roster['end_time'] ? date('Y-m-d\TH:i', strtotime($roster['end_time'])) : date('Y-m-d\TH:i', strtotime($roster['dateTimeTo'])) ?>">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('input[name="available_rosters[]"]:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one roster');
                return;
            }

            let hasError = false;
            checkedBoxes.forEach(box => {
                const rosterId = box.value;
                const startTime = document.querySelector(`input[name="start[${rosterId}]"]`).value;
                const endTime = document.querySelector(`input[name="end[${rosterId}]"]`).value;

                if (!startTime || !endTime) {
                    hasError = true;
                    alert('Please enter both start and end times for selected rosters');
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
