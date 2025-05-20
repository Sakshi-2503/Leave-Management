<?php 
require_once "include/header.php";
require_once "../connection.php";

// Check for today's government holiday
$today = date('Y-m-d');
$holiday_query = "SELECT name FROM government_holidays WHERE date = '$today'";
$holiday_result = mysqli_query($conn, $holiday_query);
$holiday_name = "";
if (mysqli_num_rows($holiday_result) > 0) {
    $holiday = mysqli_fetch_assoc($holiday_result);
    $holiday_name = $holiday['name'];
}

// Leave stats
$i = 1;
$total_accepted = $total_pending = $total_canceled = $total_applied = 0;
$leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]'";
$result = mysqli_query($conn, $leave);

if (mysqli_num_rows($result) > 0) {
    $total_applied = mysqli_num_rows($result);
    while ($leave_info = mysqli_fetch_assoc($result)) {
        $status = $leave_info["status"];
        if ($status == "pending") $total_pending++;
        elseif ($status == "Accepted") $total_accepted++;
        elseif ($status == "Canceled") $total_canceled++;
    }
}

$currentDay = date('Y-m-d', strtotime("today"));
$last_leave_status = "No leave applied";
$upcoming_leave_status = "";

// Last leave
$check_leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ORDER BY start_date DESC LIMIT 1";
$s = mysqli_query($conn, $check_leave);
if (mysqli_num_rows($s) > 0) {
    $info = mysqli_fetch_assoc($s);
    $last_leave_status = $info["status"];
}

// Upcoming leave
$check_ = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' AND start_date > '$currentDay' AND status = 'Accepted' ORDER BY start_date ASC LIMIT 1";
$e = mysqli_query($conn, $check_);
if (mysqli_num_rows($e) > 0) {
    $info = mysqli_fetch_assoc($e);
    $date = $info["start_date"];
    $upcoming_leave_status = date('jS F', strtotime($date));
}

$select_emp = "SELECT * FROM employee";
$total_emp = mysqli_query($conn, $select_emp);

$sql_highest_salary =  "SELECT * FROM employee ORDER BY salary DESC";
$emp_ = mysqli_query($conn, $sql_highest_salary);
?>

<div style="padding: 20px; background-color: #f5fff8; font-family: 'Segoe UI', sans-serif;">

    <?php if ($holiday_name): ?>
        <div style="background-color: #e6ffed; color: #166534; border-left: 5px solid #16a34a; padding: 12px; border-radius: 6px; margin-bottom: 30px; text-align: center; font-size: 18px;">
            🎉 Today is a government holiday: <strong><?php echo htmlspecialchars($holiday_name); ?></strong>. Enjoy your day off!
        </div>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px;">

        <!-- Leave Status Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center;color:rgb(8, 135, 46)">📅 Leave Status</h4>
            <p>Upcoming Leave on: <strong><?php echo $upcoming_leave_status ?: "None"; ?></strong></p>
            <p>Last Leave Status: <strong><?php echo ucwords($last_leave_status); ?></strong></p>
        </div>

        <!-- Applied Leaves Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center; color:rgb(8, 135, 46);">📋 Applied Leaves</h4>
            <p>Total Accepted: <strong><?php echo $total_accepted; ?></strong></p>
            <p>Total Canceled: <strong><?php echo $total_canceled; ?></strong></p>
            <p>Total Pending: <strong><?php echo $total_pending; ?></strong></p>
            <p>Total Applied: <strong><?php echo $total_applied; ?></strong></p>
        </div>

        <!-- Employee Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center; color:rgb(8, 135, 46);">👨‍💼 Employees</h4>
            <p>Total Employees: <strong><?php echo mysqli_num_rows($total_emp); ?></strong></p>
            <div style="text-align: center; margin-top: 10px;">
                <a href="view-employee.php" style="color: #16a34a; text-decoration: none; font-weight: bold;">🔍 View All Employees</a>
            </div>
        </div>

    </div>

 <!-- Leadership Table -->
<div style="margin-top: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
    <h4 style="text-align: center; color:rgb(8, 135, 46);">🏆 Employee Leadership Board</h4>
    
    <div style="max-height: 300px; overflow-y: auto; margin-top: 20px; border: 1px solid #a5d6a7; border-radius: 8px;">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead style="position: sticky; top: 0; background-color: rgb(8, 135, 46); color: white; z-index: 1;">
                <tr>
                    <th style="padding: 10px; text-align: left;">S.No.</th>
                    <th style="padding: 10px; text-align: left;">ID</th>
                    <th style="padding: 10px; text-align: left;">Name</th>
                    <th style="padding: 10px; text-align: left;">Email</th>
                    <th style="padding: 10px; text-align: left;">Salary (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php while($emp_info = mysqli_fetch_assoc($emp_)): ?>
                <tr style="border-bottom: 1px solid #e0f2f1;">
                    <td style="padding: 10px;"><?php echo $i++; ?></td>
                    <td style="padding: 10px;"><?php echo $emp_info["id"]; ?></td>
                    <td style="padding: 10px;"><?php echo htmlspecialchars($emp_info["name"]); ?></td>
                    <td style="padding: 10px;"><?php echo htmlspecialchars($emp_info["email"]); ?></td>
                    <td style="padding: 10px;"><?php echo $emp_info["salary"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "include/footer.php"; ?>
