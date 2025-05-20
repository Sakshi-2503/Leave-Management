<?php 
    require_once "include/header.php";
?>
    
    <?php
    require_once "include/header.php";
?>

<style>
  body {
    background-color: #eafaf1;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .login-form-bg {
    background-color: #eafaf1;
    min-height: 100vh;
    padding-top: 60px;
    padding-bottom: 60px;
  }

  .card.login-form {
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 128, 0, 0.25);
    background-color: #fff;
  }

  .card.login-form .card-body {
    padding: 30px 35px;
  }

  h4.text-center {
    color: #006400;
    font-weight: 700;
    margin-bottom: 25px;
  }

  label {
    font-weight: 600;
    color: #004d00;
  }

  .form-control {
    border: 2px solid #28a745;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 16px;
    transition: border-color 0.3s ease-in-out;
  }

  .form-control:focus {
    border-color: #006400;
    box-shadow: 0 0 5px rgba(0, 100, 0, 0.5);
    outline: none;
  }

  .form-check-label {
    color: #006400;
    font-weight: 600;
  }

  .form-check-input {
    cursor: pointer;
  }

  .btn-primary {
    background-color: #28a745;
    border: none;
    padding: 12px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 8px;
    width: 100%;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #1e7e34;
  }

  p[style*="color:red"] {
    margin-top: 6px;
    font-weight: 600;
    font-size: 14px;
  }
</style>

<?php  

        $nameErr = $emailErr = $passErr =  "";
        $name = $email = $dob = $gender = $pass = "";

        if( $_SERVER["REQUEST_METHOD"] == "POST" ){

            if( empty($_REQUEST["gender"]) ){
                $gender ="";
            }else {
                $gender = $_REQUEST["gender"];
            }


            if( empty($_REQUEST["dob"]) ){
                $dob = "";
            }else {
                $dob = $_REQUEST["dob"];
            }

            if( empty($_REQUEST["name"]) ){
                $nameErr = "<p style='color:red'> * Name is required</p>";
            }else {
                $name = $_REQUEST["name"];
            }

            if( empty($_REQUEST["email"]) ){
                $emailErr = "<p style='color:red'> * Email is required</p> ";
            }else{
                $email = $_REQUEST["email"];
            }

            if( empty($_REQUEST["pass"]) ){
                $passErr = "<p style='color:red'> * Password is required</p> ";
            }else{
                $pass = $_REQUEST["pass"];
            }


            if( !empty($name) && !empty($email) && !empty($pass) ){

                // database connection
                require_once "../connection.php";

                $sql_select_query = "SELECT email FROM admin WHERE email = '$email' ";
                $r = mysqli_query($conn , $sql_select_query);

                if( mysqli_num_rows($r) > 0 ){
                    $emailErr = "<p style='color:red'> * Email Already Register</p>";
                } else{

                    $sql = "INSERT INTO admin( name , email , password , dob, gender ) VALUES( '$name' , '$email' , '$pass' , '$dob' , '$gender' )  ";
                    $result = mysqli_query($conn , $sql);
                    if($result){
                        $name = $email = $dob = $gender = $pass = "";
                        echo "<script>
                        $(document).ready( function(){
                            $('#showModal').modal('show');
                            $('#modalHead').hide();
                            $('#linkBtn').attr('href', 'manage-admin.php');
                            $('#linkBtn').text('View Admins');
                            $('#addMsg').text('Admin Added Successfully!');
                            $('#closeBtn').text('Add More?');
                        })
                     </script>
                     ";
                }

            }
        }
    }

?>



<div style=""> 
<div class="login-form-bg h-100">
        <div class="container mt-2 h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-2 shadow">                       
                                    <h4 class="text-center">Add New Admin</h4>
                                <form method="POST" action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            
                                <div class="form-group">
                                    <label >Full Name :</label>
                                    <input type="text" class="form-control" value="<?php echo $name; ?>"  name="name" >
                                   <?php echo $nameErr; ?>
                                </div>


                                <div class="form-group">
                                    <label >Email :</label>
                                    <input type="email" class="form-control" value="<?php echo $email; ?>"  name="email" >     
                                    <?php echo $emailErr; ?>
                                </div>

                                <div class="form-group">
                                    <label >Password: </label>
                                    <input type="password" class="form-control" value="<?php echo $pass; ?>" name="pass" > 
                                    <?php echo $passErr; ?>           
                                </div>

                                <div class="form-group">
                                    <label >Date-of-Birth :</label>
                                    <input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob" >  
                                   
                                </div>

                                <div class="form-group form-check form-check-inline">
                                    <label class="form-check-label" >Gender :</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Male" ){ echo "checked"; } ?>  value="Male"  selected>
                                    <label class="form-check-label" >Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Female" ){ echo "checked"; } ?>  value="Female">
                                    <label class="form-check-label" >Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Other" ){ echo "checked"; } ?>  value="Other">
                                    <label class="form-check-label" >Other</label>
                                </div>
                                <br>

                                <button type="submit" class="btn btn-primary btn-block">Add</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    require_once "include/footer.php";
?>


<?php 
    require_once "include/footer.php";
?>