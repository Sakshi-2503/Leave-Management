<?php
session_start();
$employeeId = $_SESSION['employee_id']; // Assumes you're using sessions for login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php'; // your DB connection

    $status = $_POST['status'];
    $date = date('Y-m-d');
    $checkIn = date('H:i:s');

    // Prevent duplicate entry
    $check = $conn->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
    $check->bind_param("is", $employeeId, $date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO attendance (employee_id, date, status, check_in_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $employeeId, $date, $status, $checkIn);
        if ($stmt->execute()) {
            echo "Attendance marked successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You have already marked attendance today.";
    }
}
?>

<form method="POST" action="">
    <label>Status:</label>
    <select name="status" required>
        <option value="Present">Present</option>
        <option value="Leave">Leave</option>
        <option value="Absent">Absent</option>
    </select>
    <button type="submit">Mark Attendance</button>
</form>
