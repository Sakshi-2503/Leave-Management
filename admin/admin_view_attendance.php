<?php
session_start();
include 'db.php'; // Database connection

// Optional: check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

$sql = "SELECT a.date, a.status, a.check_in_time, a.check_out_time, e.name 
        FROM attendance a
        INNER JOIN employees e ON a.employee_id = e.id
        ORDER BY a.date DESC, e.name";

$result = $conn->query($sql);

echo "<h2>Employee Attendance Records</h2>";
echo "<table border='1' cellpadding='10'>
<tr>
    <th>Employee Name</th>
    <th>Date</th>
    <th>Status</th>
    <th>Check-In</th>
    <th>Check-Out</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['date']}</td>
        <td>{$row['status']}</td>
        <td>{$row['check_in_time']}</td>
        <td>{$row['check_out_time']}</td>
    </tr>";
}

echo "</table>";
?>









<?php
session_start();
require_once "../connection.php";

// Simple admin session check (adjust as needed)
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Join attendance with employee details
$sql = "SELECT a.date, a.status, a.created_at, e.name, e.email 
        FROM attendance a
        JOIN employee e ON a.employee_id = e.id
        ORDER BY a.date DESC, e.name ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>All Employees Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>All Employees Attendance</h3>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Marked At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $statusClass = $row['status'] === 'Present' ? 'text-success' : 'text-danger';
                    echo "<tr>
                        <td>" . htmlspecialchars(date("d-M-Y", strtotime($row['date']))) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td class='$statusClass'>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars(date("h:i A", strtotime($row['created_at']))) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No attendance records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
