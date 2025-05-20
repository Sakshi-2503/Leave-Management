<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1) Check if employee is logged in
if (!isset($_SESSION['emp_id'])) {
    header('Location: ../login.php');
    exit;
}

// 2) Include the database connection
require_once __DIR__ . '/../connection.php';

$emp_id = (int) $_SESSION['emp_id'];
$today = date('Y-m-d');
$message = '';

// 3) Check if attendance already marked
$check_sql = "SELECT id FROM attendance WHERE employee_id = $emp_id AND date = '$today'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    $message = "You have already marked your attendance for today.";
} else {
    // 4) Insert attendance
    $status = 'Present'; // Change if needed (e.g., via form input)
    $insert_sql = "INSERT INTO attendance (employee_id, date, status) VALUES ($emp_id, '$today', '$status')";

    if (mysqli_query($conn, $insert_sql)) {
        $message = "Attendance marked successfully for $today.";
    } else {
        $message = "Database error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mark Attendance</title>
  <link href="../resorce/css/style.css" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/include/header.php'; ?>

<div class="content-body">
  <div style="max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px;">
    <h2>Mark Attendance</h2>
    <p><?= $message ?></p>
    <p><a href="employee_attendance_history.php">→ View Attendance History</a></p>
  </div>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>

</body>
</html>
