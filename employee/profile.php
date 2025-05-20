<?php 
require_once "include/header.php";
?>

<!-- ✅ Add your style block here -->
<style>
/* Strict Green & White Theme */
body {
  background-color: #f6fff6;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    justify-content: center;

}

.container {
  margin-top: 20px;
  display: flex;
  justify-content: center;
}

.card {
  width: 22rem;
  border-radius: 12px;
  background-color: #ffffff;
  box-shadow: 0 6px 20px rgba(0, 128, 0, 0.15);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(0, 128, 0, 0.3);
}

.card-img-top {
  height: 300px;
  object-fit: cover;
  border-bottom: 4px solid #2e7d32;
  border-radius: 12px 12px 0 0;
}

.card-body {
  padding: 25px 30px;
  color: #2e7d32;
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
    color: #2e7d32;
    margin-bottom: 10px;
}

.text-center {
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}

.btn-outline-primary {
  border: 2px solid #2e7d32;
  color: #2e7d32;
  padding: 8px 16px;
  font-size: 1rem;
  border-radius: 6px;
  background-color: #ffffff;
  transition: background-color 0.3s ease, color 0.3s ease;
  text-decoration: none;
}

.btn-outline-primary:hover {
  background-color: #2e7d32;
  color: #ffffff;
}

.mt-2 {
  margin-top: 0.5rem !important;
}

@media (max-width: 767px) {
  .card {
    width: 100% !important;
    margin: 0 15px;
  }
}
</style>


<?php  
require_once "../connection.php";

// Fetch employee data
$sql_command = "SELECT * FROM employee WHERE email = '$_SESSION[email_emp]' ";
$result = mysqli_query($conn , $sql_command);

if( mysqli_num_rows($result) > 0){
   while( $rows = mysqli_fetch_assoc($result) ){
       $name = ucwords($rows["name"]);
       $gender = ucwords($rows["gender"]);
       $dob= $rows["dob"];
        $salary = $rows["salary"];   
        $dp = $rows["dp"];     
        $id = $rows["id"];
   }

   if( empty($gender)){
       $gender = "Not Defined";
   }else{
    $dob = date('jS F Y' , strtotime($dob) );
   }

   if( empty($dob)){
        $dob = "Not Defined";
        $age = "Not Defined";
    }else{
            $date1=date_create($dob);
            $date2=date_create("now");
            $diff=date_diff($date1,$date2);
            $age = $diff->format("%y Years"); 
    }
}
?>

<!-- Your HTML content continues as is... -->



<div class="container">
    <div class="row justify-content-center align-items-center">
        <!-- Profile Photo (Left Side) -->
        <div class="col-md-5 text-center mb-4 mb-md-0">
            <img src="upload/<?php echo !empty($dp) ? $dp : '1.jpg'; ?>" 
                 class="rounded shadow img-fluid" 
                 style="max-height: 400px; width: auto;" 
                 alt="Profile Photo">
            <div class="mt-3">
                <a href="profile-photo.php" class="btn btn-outline-primary">Change Profile Photo</a>
            </div>
        </div>

        <!-- Profile Info (Right Side) -->
        <div class="col-md-7">
            <div class="card shadow p-4">
                <h2 class="text-center mb-4"><?php echo $name; ?></h2>
                <p class="card-text"><strong>Email:</strong> <?php echo $_SESSION["email_emp"]; ?></p>
                <p class="card-text"><strong>Employee ID:</strong> <?php echo $id; ?></p>
                <p class="card-text"><strong>Gender:</strong> <?php echo $gender; ?></p>
                <p class="card-text"><strong>Age:</strong> <?php echo $age; ?></p>
                <p class="card-text"><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
                <p class="card-text"><strong>Salary:</strong> <?php echo $salary . " Rs."; ?></p>

                <div class="text-center mt-4">
                    <a href="edit-profile.php" class="btn btn-outline-primary me-2">Edit Profile</a>
                    <a href="change-password.php" class="btn btn-outline-primary">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once "include/footer.php";
?>