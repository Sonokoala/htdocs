
<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['staffID']) || !isset($_SESSION['roleID'])) {
    header("Location: login.php");
    exit();
}
require_once "db.php";

$roleID = $_SESSION['roleID'];
$staffID = $_SESSION['staffID'];

if ($roleID == 2) {
    // マネージャー：全スタッフのアベイラビリティを表示
    $sql = "SELECT s.staffID, s.name, r.rosterID, r.dateTimeFrom, r.dateTimeTo
            FROM staff s
            JOIN availability a ON s.staffID = a.staffID
            JOIN roster r ON a.rosterID = r.rosterID
            ORDER BY s.staffID, r.dateTimeFrom";
    $result = $connection->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
} else {
    // スタッフ本人のみ
    $stmt = $connection->prepare("
        SELECT r.rosterID, r.dateTimeFrom, r.dateTimeTo 
        FROM availability a
        JOIN roster r ON a.rosterID = r.rosterID
        WHERE a.staffID = ?
        ORDER BY r.dateTimeFrom
    ");
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Availability</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="container my-5">
  <h2><?= $roleID == 2 ? "All Staff Availability" : "My Availability" ?></h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <?php if ($roleID == 2): ?>
          <th>Staff ID</th>
          <th>Name</th>
        <?php endif; ?>
        <th>Roster ID</th>
        <th>Date</th>
        <th>Start</th>
        <th>End</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($rows as $row): ?>
        <tr>
          <?php if ($roleID == 2): ?>
            <td><?= htmlspecialchars($row['staffID']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
          <?php endif; ?>
          <td><?= htmlspecialchars($row['rosterID']) ?></td>
          <td><?= htmlspecialchars(date('Y-m-d', strtotime($row['dateTimeFrom']))) ?></td>
          <td><?= htmlspecialchars(date('H:i', strtotime($row['dateTimeFrom']))) ?></td>
          <td><?= htmlspecialchars(date('H:i', strtotime($row['dateTimeTo']))) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
