<?php
session_start();

$email_err = $pass_err = $login_Err = "";
$email = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_REQUEST["email"])) {
        $email_err = "<p class='text-danger small'>* Email can not be empty</p>";
    } else {
        $email = $_REQUEST["email"];
    }

    if (empty($_REQUEST["password"])) {
        $pass_err = "<p class='text-danger small'>* Password can not be empty</p>";
    } else {
        $pass = $_REQUEST["password"];
    }

    if (!empty($email) && !empty($pass)) {
        require_once "../connection.php";

        $sql_query = "SELECT * FROM employee WHERE email=? AND password=?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_unset();
            $row = $result->fetch_assoc();
            $_SESSION["email_emp"] = $row["email"];
            $_SESSION["employee_id"] = $row["id"];
            $_SESSION["employee_name"] = $row["name"];
            header("Location: dashboard.php?login-success");
            exit();
        } else {
            $login_Err = "<div class='alert alert-warning alert-dismissible fade show'>
              <strong>Invalid Email/Password</strong>
              <button type='button' class='close' data-dismiss='alert'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Employee Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

  <style>
    html, body {
  height: 100%;
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
}

.bg {
  background-image: url("../background.jpg"); /* Keep your image */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  background-color: rgba(255, 255, 255, 0.95); /* White with light transparency */
  border: 2px solid green;
  border-radius: 15px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  padding: 40px 30px;
  width: 100%;
  max-width: 500px;
}

h4 {
  color: green;
  font-weight: 600;
  margin-bottom: 30px;
}

.btn-primary {
  background-color: green;
  border: none;
  font-weight: bold;
}

.btn-primary:hover {
  background-color: darkgreen;
}

.btn-primary:focus,
.btn-primary:active,
.btn-primary:focus:active {
  background-color: green !important;
  border: none !important;
  box-shadow: none !important;
  outline: none !important;
}

.login-form__footer {
  margin-top: 20px;
  text-align: center;
  color: green;
}

.login-form__footer a {
  color: blue;
  font-weight: bold;
}

.form-group label {
  font-weight: 500;
  color: green;
}

.form-control {
  border: 1px solid green;
  color: green;
}

.form-control::placeholder {
  color: #3c763d;
}

.alert-warning {
  background-color: #f8f9e4;
  border: 1px solid green;
  color: green;
}

  </style>
</head>
<body>

  <div class="bg">
    <div class="login-card">
      <h4 class="text-center">Hello, Employee</h4>
      <div class="text-center mb-4"><?php echo $login_Err; ?></div>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
          <label>Email:</label>
          <input type="email" class="form-control" value="<?php echo $email; ?>" name="email">
          <?php echo $email_err; ?>
        </div>
        <div class="form-group">
          <label>Password:</label>
          <input type="password" class="form-control" name="password">
          <?php echo $pass_err; ?>
        </div>
        <div class="form-group">
          <input type="submit" value="Log-In" class="btn btn-primary btn-lg w-100" name="signin">
        </div>
        <p class="login-form__footer">Not an employee? <a href="../admin/login.php" class="text-primary">Log-In</a> as Admin now</p>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
