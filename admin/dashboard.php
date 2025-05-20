<?php 
require_once "include/header.php";
require_once "../connection.php";

// Date setup
$currentDay = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime("+1 day"));

// Leave stats
$today_leave = 0;
$tomorrow_leave = 0;
$i = 1;

// Total Admins
$select_admins = "SELECT * FROM admin";
$total_admins = mysqli_query($conn , $select_admins);

// Total Employees
$select_emp = "SELECT * FROM employee";
$total_emp = mysqli_query($conn , $select_emp);

// Leaves
$emp_leave  = "SELECT * FROM emp_leave";
$total_leaves = mysqli_query($conn , $emp_leave);

if(mysqli_num_rows($total_leaves) > 0){
    while($leave = mysqli_fetch_assoc($total_leaves)){
        $leave_date = $leave["start_date"];
        if($leave_date == $currentDay){
            $today_leave++;
        } elseif($leave_date == $tomorrow){
            $tomorrow_leave++;
        }
    }
}

// Highest Paid Employees
$sql_highest_salary =  "SELECT * FROM employee ORDER BY salary DESC";
$emp_ = mysqli_query($conn , $sql_highest_salary);
?>

<div style="padding: 20px; background-color: #f5fff8; font-family: 'Segoe UI', sans-serif;">

    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px;">

        <!-- Admins Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center; color:rgb(8, 135, 46);">🛡️ Admins</h4>
            <p>Total Admins: <strong><?php echo mysqli_num_rows($total_admins); ?></strong></p>
            <div style="text-align: center; margin-top: 10px;">
                <a href="manage-admin.php" style="color: #16a34a; text-decoration: none; font-weight: bold;">🔍 View All Admins</a>
            </div>
        </div>

        <!-- Employees Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center; color:rgb(8, 135, 46);">👨‍💼 Employees</h4>
            <p>Total Employees: <strong><?php echo mysqli_num_rows($total_emp); ?></strong></p>
            <div style="text-align: center; margin-top: 10px;">
                <a href="manage-employee.php" style="color: #16a34a; text-decoration: none; font-weight: bold;">🔍 View All Employees</a>
            </div>
        </div>

        <!-- Leave Status Card -->
        <div style="flex: 1; min-width: 280px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <h4 style="text-align: center; color:rgb(8, 135, 46);">📅 Leave Summary</h4>
            <p>Employees on Leave Today: <strong><?php echo $today_leave; ?></strong></p>
            <p>Employees on Leave Tomorrow: <strong><?php echo $tomorrow_leave; ?></strong></p>
        </div>

    </div>

    <!-- Leadership Table -->
<div style="margin-top: 50px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
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
