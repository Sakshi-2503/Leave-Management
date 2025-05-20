<?php
require_once "include/header.php";
require_once "../connection.php"; // Needed for fetching leave types
?>

<style>
    body {
        background-color: #f1fdf4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-input-content {
        margin-top: 20px;
    }

    .card.login-form {
        border-radius: 10px;
        border: none;
        background-color: #ffffff;
        box-shadow: 0 0 15px rgba(0, 128, 0, 0.1);
    }

    .card-body h4 {
        font-weight: bold;
        margin-bottom: 30px;
        color: #2e7d32;    }

    .form-group label {
        font-weight: 600;
        color: #444;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.4);
        outline: none;
    }

    .btn-success {
        background-color: #2e7d32;
        border-color: #28a745;
        padding: 10px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .text-center {
        text-align: center;
    }

    p[style*="color:red"] {
        margin-top: 5px;
        font-size: 14px;
    }
</style>

<?php
$reasonErr = $startdateErr = $lastdateErr = "";
$reason = $startdate = $lastdate = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST["reason"] ?? '';
    $startdate = $_POST["startDate"] ?? '';
    $lastdate = $_POST["lastDate"] ?? '';
    $leave_type_id = $_POST['leave_type'] ?? '';
    $email = $_SESSION['email_emp'];

    if (empty($reason)) $reasonErr = "<p style='color:red'>* Reason is Required</p>";
    if (empty($startdate)) $startdateErr = "<p style='color:red'>* Start Date is Required</p>";
    if (empty($lastdate)) $lastdateErr = "<p style='color:red'>* Last Date is Required</p>";

    if (!empty($reason) && !empty($startdate) && !empty($lastdate) && !empty($leave_type_id)) {
        $limit_sql = "SELECT * FROM leave_types WHERE id = $leave_type_id";
        $limit_result = mysqli_query($conn, $limit_sql);
        $leave_type = mysqli_fetch_assoc($limit_result);

        $leave_name = $leave_type['name'];
        $max_monthly = $leave_type['max_monthly'];
        $max_yearly = $leave_type['max_yearly'];

        $year = date('Y', strtotime($startdate));
        $month = date('m', strtotime($startdate));

        $year_sql = "SELECT COUNT(*) AS count FROM emp_leave 
                     WHERE email = '$email' AND leave_type_id = $leave_type_id 
                     AND status = 'Accepted' AND YEAR(start_date) = '$year'";
        $year_count = mysqli_fetch_assoc(mysqli_query($conn, $year_sql))['count'];

        $month_sql = "SELECT COUNT(*) AS count FROM emp_leave 
                      WHERE email = '$email' AND leave_type_id = $leave_type_id 
                      AND status = 'Accepted' AND MONTH(start_date) = '$month' 
                      AND YEAR(start_date) = '$year'";
        $month_count = mysqli_fetch_assoc(mysqli_query($conn, $month_sql))['count'];

        if (!is_null($max_yearly) && $year_count >= $max_yearly) {
            echo "<p style='color:red;'>❌ You have reached your <strong>yearly limit</strong> for $leave_name.</p>";
        } elseif (!is_null($max_monthly) && $month_count >= $max_monthly) {
            echo "<p style='color:red;'>❌ You have reached your <strong>monthly limit</strong> for $leave_name.</p>";
        } else {
            $sql = "INSERT INTO emp_leave (reason, start_date, last_date, email, status, leave_type_id)
                    VALUES ('$reason', '$startdate', '$lastdate', '$email', 'pending', $leave_type_id)";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                    $(document).ready(function(){
                        $('#showModal').modal('show');
                        $('#addMsg').text('Leave Applied Successfully!');
                        $('#linkBtn').attr('href', 'leave-status.php');
                        $('#linkBtn').text('Check Leave Status');
                        $('#closeBtn').text('Apply Another');
                    });
                </script>";
                $reason = $startdate = $lastdate = "";
            }
        }
    }
}
?>

<!-- Leave Form UI -->
<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6 pt-2">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5 shadow">
                            <h4 class="text-center">Apply For Leave</h4>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                
                                <div class="form-group">
                                    <label>Leave Type :</label>
                                    <select name="leave_type" class="form-control" required>
                                        <option value="">-- Select Leave Type --</option>
                                        <?php 
                                        $lt_query = "SELECT * FROM leave_types";
                                        $lt_result = mysqli_query($conn, $lt_query);
                                        while ($lt = mysqli_fetch_assoc($lt_result)) {
                                            echo "<option value='{$lt['id']}'>{$lt['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Reason :</label>
                                    <input type="text" class="form-control" name="reason" value="<?php echo htmlspecialchars($reason); ?>">
                                    <?php echo $reasonErr; ?>
                                </div>

                                <div class="form-group">
                                    <label>Start Date :</label>
                                    <input type="date" class="form-control" name="startDate" value="<?php echo htmlspecialchars($startdate); ?>">
                                    <?php echo $startdateErr; ?>
                                </div>

                                <div class="form-group">
                                    <label>Last Date :</label>
                                    <input type="date" class="form-control" name="lastDate" value="<?php echo htmlspecialchars($lastdate); ?>">
                                    <?php echo $lastdateErr; ?>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Apply Now" class="btn btn-success btn-lg w-100" name="signin">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "include/footer.php"; ?>  
