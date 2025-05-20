*<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

    require_once "include/header.php";

require_once "../connection.php";

if (!isset($_SESSION['employee_id'])) {
    // If no session, redirect to login page
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare SQL statement
$sql = "SELECT date, status, created_at FROM attendance WHERE employee_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

// You can remove the debug lines once it works
// echo "Found rows: " . $result->num_rows;
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         var_dump($row);
//         break; // only first row to check output
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Attendance History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" />
    <style>
        /* Container and card styling */
        body.bg-light {
    background-color: #f4fdf5;
  }
.container {
    max-width: 900px;
}

.card {
    border-radius: 8px;
}

.card-header {
    font-size: 1.5rem;
    letter-spacing: 1px;
}

/* Table styling */
.table {
    font-size: 1rem;
}

.table thead tr {
    background-color: #e9f5e9; /* light green background for header */
}

.table thead th {
    color: #155724; /* dark green text */
    font-weight: 600;
    text-align: center;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
}

/* Status colors handled inline but you can add classes if you want */

/* Button styling */
.btn {
    border-radius: 25px;
    padding: 8px 25px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0b3d07 !important; /* Darker green on hover */
    color: #fff !important;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .card-header {
        font-size: 1.2rem;
    }

    .table {
        font-size: 0.9rem;
    }

    .btn {
        padding: 6px 15px;
        font-size: 0.9rem;
    }
}

        </style>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card border-0 shadow">
        <div class="card-header text-white text-center font-weight-bold" style="background-color: rgb(8, 161, 18);">
            My Attendance History
        </div>

        <div class="card-body bg-white">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black;">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Marked At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusColor = strtolower($row['status']) === 'present' ? '#2e7d32' : '#dc3545';
                                echo "<tr>
                                    <td>" . htmlspecialchars(date("d-M-Y", strtotime($row['date']))) . "</td>
                                    <td style='color: $statusColor; font-weight: bold;'>" . htmlspecialchars($row['status']) . "</td>
                                    <td>" . htmlspecialchars(date("h:i A", strtotime($row['created_at']))) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center text-muted'>No attendance records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="text-right">
                <a href="mark_attendance.php" class="btn mt-3 text-white" style="background-color: rgb(8, 161, 18);">Mark Attendance</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php 
    require_once "include/footer.php";
?>  
