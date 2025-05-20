<?php
session_start();
require_once "../connection.php"; // Adjust path if needed

// Check if employee is logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['attendance_status'] ?? '';

    if ($status === 'Present' || $status === 'Absent') {
        $today = date('Y-m-d');

        // Check if attendance already marked for today
        $check_sql = "SELECT id FROM attendance WHERE employee_id = ? AND date = ?";
        $stmt = $conn->prepare($check_sql);
        if (!$stmt) {
            $_SESSION['error_msg'] = "Database error: " . $conn->error;
            header("Location: mark_attendance.php");
            exit();
        }
        $stmt->bind_param("is", $employee_id, $today);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            // Insert attendance record
            $insert_sql = "INSERT INTO attendance (employee_id, status, date, created_at) VALUES (?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_sql);
            if (!$insert_stmt) {
                $_SESSION['error_msg'] = "Database error: " . $conn->error;
                header("Location: mark_attendance.php");
                exit();
            }
            $insert_stmt->bind_param("iss", $employee_id, $status, $today);

            if ($insert_stmt->execute()) {
                $_SESSION['success_msg'] = "Attendance marked successfully.";
            } else {
                $_SESSION['error_msg'] = "Error marking attendance: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        } else {
            $_SESSION['error_msg'] = "You have already marked attendance for today.";
        }

        $stmt->close();
    } else {
        $_SESSION['error_msg'] = "Invalid attendance status selected.";
    }

    header("Location: mark_attendance.php");
    exit();
}
?>
<?php

require_once "include/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<style>
  body.bg-light {
    background-color: #f4fdf5;
  }

  .container {
    max-width: 500px;
    margin-top: 60px;
  }

  .card {
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    border: 1px solid #c8e6c9;
  }

  h4, h6 {
    font-weight: 600;
    color: #2e7d32;
    text-align: center;
  }

  .form-check {
    margin-bottom: 15px;
  }

  .form-check-input:checked ~ .form-check-label {
    font-weight: 600;
    color: #2e7d32;
  }

  .btn-primary {
    background-color: #2e7d32;
    border: none;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #27642a;
  }

  .alert-success {
    background-color: #d0f0d4;
    color: #2e7d32;
    border-color: #a5d6a7;
    font-weight: 500;
    border-radius: 8px;
  }

  .alert-danger {
    background-color: #ffebee;
    color: #c62828;
    border-color: #ef9a9a;
    font-weight: 500;
    border-radius: 8px;
  }

  a.text-center,
  .text-center a {
    color: #2e7d32;
    font-weight: 500;
    text-decoration: none;
    display: block;
    text-align: center;
  }

  a.text-center:hover,
  .text-center a:hover {
    text-decoration: underline;
    color: #1b5e20;
  }
</style>


</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card p-4 shadow-sm">
        <h4 class="mb-4">Mark Attendance</h4>
                <h6 class="mb-4">Select your Attendance Status</h6>


        <?php if (!empty($_SESSION['success_msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_msg']) ?></div>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="attendance_status" id="present" value="Present" required>
                <label class="form-check-label" for="present">Present</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="attendance_status" id="absent" value="Absent" required>
                <label class="form-check-label" for="absent">Absent</label>
            </div>

            <button type="submit" class="btn btn-success mt-3 w-100">Mark Attendance</button>
        </form>

        <a href="employee_attendance_history.php" class="d-block mt-3 text-center">View My Attendance History</a>
    </div>
</div>

</body>
</html>
<?php 
    require_once "include/footer.php";
?>