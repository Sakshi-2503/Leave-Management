<?php 
require_once "include/header.php";
require_once "../connection.php";
?>

<style>
body {
  background-color: #f6fff6;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container {
  margin-top: 30px;
}

.card {
  border-radius: 12px;
  background-color: #ffffff;
  box-shadow: 0 6px 20px rgba(0, 128, 0, 0.15);
  padding: 20px;
}

.card-body h2 {
  font-weight: 700;
  font-size: 1.8rem;
  color: #2e7d32;
  margin-bottom: 25px;
  text-align: center;
}

.card-text {
  font-size: 1.05rem;
  margin-bottom: 10px;
  color: #2e7d32;
}

.text-center {
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}

.btn-outline-success {
  border: 2px solid #2e7d32;
  color: #2e7d32;
  padding: 8px 16px;
  font-size: 1rem;
  border-radius: 6px;
  background-color: #ffffff;
  transition: background-color 0.3s ease, color 0.3s ease;
  text-decoration: none;
}

.btn-outline-success:hover {
  background-color: #2e7d32;
  color: #ffffff;
}

@media (max-width: 767px) {
  .card {
    margin: 0 15px;
  }
}
</style>

<?php
$sql_command = "SELECT * FROM admin WHERE email = '$_SESSION[email]' ";
$result = mysqli_query($conn , $sql_command);

if(mysqli_num_rows($result) > 0){
    while($rows = mysqli_fetch_assoc($result)){
        $name = ucwords($rows["name"]);
        $gender = ucwords($rows["gender"]);
        $dob = $rows["dob"];
        $dp = $rows["dp"];
    }

    $gender = empty($gender) ? "Not Defined" : $gender;
    if(empty($dob)){
        $dob = "Not Defined";
        $age = "Not Defined";
    } else {
        $date1 = date_create($dob);
        $date2 = date_create("now");
        $diff = date_diff($date1, $date2);
        $age = $diff->format("%y Years");
        $dob = date('jS F Y', strtotime($dob));
    }
}
?>

<div class="container">
  <div class="row justify-content-center align-items-center">
    <!-- Left: Profile Image -->
    <div class="col-md-5 text-center mb-4 mb-md-0">
      <img src="upload/<?php echo !empty($dp) ? $dp : '1.jpg'; ?>" 
           class="rounded shadow img-fluid" 
           style="max-height: 400px; width: auto;" 
           alt="Profile Photo">
      <div class="mt-3">
        <a href="profile-photo.php" class="btn btn-outline-success">Change Profile Photo</a>
      </div>
    </div>

    <!-- Right: Profile Info -->
    <div class="col-md-7">
      <div class="card shadow p-4">
        <h2><?php echo $name; ?></h2>
        <p class="card-text"><strong>Email:</strong> <?php echo $_SESSION["email"]; ?></p>
        <p class="card-text"><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p class="card-text"><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p class="card-text"><strong>Age:</strong> <?php echo $age; ?></p>

        <div class="text-center mt-4">
          <a href="edit-profile.php" class="btn btn-outline-success">Edit Profile</a>
          <a href="change-password.php" class="btn btn-outline-success">Change Password</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
require_once "include/footer.php";
?>
