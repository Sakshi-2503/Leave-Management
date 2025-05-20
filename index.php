<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Management System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <style>
      html, body {
        height: 100%;
        margin: 0;
      }

      .bg {
        background-image: url("view-young-business-people-keeping-team-building-modern-office_52137-1240.avif"); /* ✅ Your uploaded image */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 500px;
        width: 100%;
      }

      h2, h6 {
        color: #2e7d32;
        font-weight: 600;
      }

      .btn-primary {
        background-color: #2e7d32;
        border-color: #2e7d32;
        font-weight: 600;
        padding: 10px 25px;
        margin: 5px;
      }

      .btn-primary:hover {
        background-color: #256c2c;
        border-color: #256c2c;
      }
      .btn-primary:focus,
.btn-primary:active,
.btn-primary:focus:active {
  background-color: #2e7d32 !important;
  border-color: #2e7d32 !important;
  box-shadow: none !important;
  outline: none !important;
  color: #fff !important;
}

    </style>
  </head>
  <body>

    <div class="bg">
      <div class="login-card">
        <h2 class="pb-2">Employee Management System</h2>
        <h6 class="pb-4">Please Log-In According To Your Role!!</h6>
        <div class="d-flex justify-content-around">
          <a href="employee/dashboard.php" class="btn btn-primary">Log-in As Employee</a>
          <a href="admin/dashboard.php" class="btn btn-primary">Log-In As Admin</a>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
