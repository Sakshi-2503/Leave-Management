<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../connection.php";

// Validate employee ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Employee ID is missing.");
}

$emp_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get employee info
$query = "SELECT * FROM employee WHERE id = $emp_id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Employee not found.");
}

$row = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    if (empty($salary) || !is_numeric($salary)) {
        $_SESSION['error_message'] = "Please enter a valid numeric salary.";
    } else {
        $update_query = "UPDATE employee SET salary = '$salary' WHERE id = $emp_id";
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['success_message'] = "Salary updated successfully for " . htmlspecialchars($row['name']) . ".";
        } else {
            $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
        }
        header("Location: salary_management.php");
        exit();
    }
}
?>

<?php require_once "include/header.php"; ?>

<style>
    body {
        background-color: #eef8f1;
    }

    .container {
        margin-top: 50px;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #c3e6cb;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1);
    }

    .card h4 {
        color: #155724;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-success {
        background-color:rgb(38, 169, 66);
        border-color: white;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }

    .form-label {
        font-weight: 500;
        color: #155724;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="container">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <a href="salary_management.php" class="btn btn-sm btn-success mb-3">&larr; Back to List</a>
            <h4 class="mb-4">Update Salary for “<?php echo htmlspecialchars($row['name']); ?>”</h4>

            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="salary" class="form-label">New Salary:</label>
                    <input type="text" id="salary" name="salary" class="form-control"
                        value="<?php echo htmlspecialchars($row['salary']); ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Update Salary</button>
            </form>
        </div>
    </div>
</div>

<?php require_once "include/footer.php"; ?>
