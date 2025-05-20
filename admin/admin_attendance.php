<?php
require_once "include/header.php";
require_once '../connection.php';

// Default values
$year = date('Y');
$month = date('m');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year'] ?? $year;
    $month = $_POST['month'] ?? $month;
}

$sql = "SELECT a.date, e.name AS employee_name, a.status
        FROM attendance a
        JOIN employee e ON a.employee_id = e.id
        WHERE YEAR(a.date) = ? AND MONTH(a.date) = ?
        ORDER BY a.date, e.name";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("ii", $year, $month);
$stmt->execute();
$result = $stmt->get_result();

$currentYear = date('Y');
$years = range($currentYear - 5, $currentYear + 1);
$months = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May',
    6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October',
    11 => 'November', 12 => 'December'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Employee Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #eef8f1;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }
        h4 {
            color: #0c7811;
            text-align: center;
            margin-bottom: 25px;
        }
        form.form-inline {
            justify-content: center;
        }
        select.form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 6px 10px;
        }
        button.btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 6px 14px;
            border-radius: 6px;
        }
        button.btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        table.table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        thead.thead-success {
            background-color: #28a745 !important;
            color: white;
        }
        th, td {
            vertical-align: middle !important;
            text-align: center;
        }
        tbody tr:hover {
            background-color: #e9f7ef;
        }
        .badge-present {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .badge-absent {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .badge-leave {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .text-center {
            font-weight: 500;
            color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h4>All Employees Attendance - <?php echo $months[(int)$month] . " " . $year; ?></h4>
    <form method="post" class="form-inline mb-3">
        <select name="year" class="form-control mr-2">
            <?php foreach ($years as $y): ?>
                <option value="<?= $y ?>" <?= ($y == $year) ? "selected" : "" ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>

        <select name="month" class="form-control mr-2">
            <?php foreach ($months as $num => $name): ?>
                <option value="<?= $num ?>" <?= ($num == (int)$month) ? "selected" : "" ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-success">Filter</button>
    </form>

    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 6px;">
    <table class="table table-bordered table-striped mb-0">
        <thead class="thead-success" style="position: sticky; top: 0; z-index: 10;">
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                    <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                    <td>
                        <?php
                            $status = strtolower($row['status']);
                            if ($status == 'present') {
                                echo '<span class="badge badge-present">Present</span>';
                            } elseif ($status == 'absent') {
                                echo '<span class="badge badge-absent">Absent</span>';
                            } elseif ($status == 'leave') {
                                echo '<span class="badge badge-leave">Leave</span>';
                            } else {
                                echo htmlspecialchars($row['status']);
                            }
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center">No attendance records found for selected month.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php require_once "include/footer.php"; ?>
