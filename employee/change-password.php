<?php 
require_once "include/header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<style>
    body {
        background-color: #f4fdf6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-form-bg {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Align to top instead of center */
    padding-top: 30px; /* Adjust spacing from top */
    min-height: 70vh;
    }


    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.15);
        padding: 30px;
    }

    .card h4 {
        color: #2e7d32;
        margin-bottom: 25px;
        font-weight: bold;
    }

    .form-group label {
        font-weight: 600;
        color: #2e7d32;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #c8e6c9;
        background-color: #f1fcf2;
        border-radius: 6px;
        margin-bottom: 8px;
        font-size: 15px;
        color: #2e7d32;
    }

    .form-control:focus {
        border-color: #66bb6a;
        outline: none;
        background-color: #ffffff;
    }

    .btn-primary {
        background-color: #2e7d32;
        color: white;
        padding: 8px 20px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #1b5e20;
        cursor: pointer;
    }

    .btn-toolbar {
        margin-top: 15px;
        gap: 10px;
    }

    .text-center {
        text-align: center;
    }

    p {
        margin: 5px 0 10px;
        color: red;
    }

    .shadow {
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
    }
</style>

<?php 
      $old_passErr = $new_passErr = $confirm_passErr = "";
     $old_pass = $new_pass = $confirm_pass = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_REQUEST["old_pass"])){
            $old_passErr = " <p style='color:red'>* Old Password Is required </p>";
        }else{
            $old_pass = trim($_REQUEST["old_pass"]);
        }
        
        if(empty($_REQUEST["new_pass"])){
            $new_passErr = " <p style='color:red'>* New Password Is required </p>";
        }else{
            $new_pass = trim($_REQUEST["new_pass"]);
        }

        if(empty($_REQUEST["confirm_pass"])){
            $confirm_passErr = " <p style='color:red'>* Please Confirm new Password! </p>";
        }else{
            $confirm_pass = trim($_REQUEST["confirm_pass"]);
        }

        if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass) ){

            require_once "../connection.php";

            $check_old_pass = "SELECT password FROM employee WHERE email = '$_SESSION[email_emp]' && password = '$old_pass' ";
            $result = mysqli_query($conn , $check_old_pass);
            if( mysqli_num_rows($result) > 0 ){
               
                if( $new_pass === $confirm_pass ){
                  
                    $change_pass_query = "UPDATE employee SET password = '$new_pass' WHERE email = '$_SESSION[email_emp]' ";
                    if (mysqli_query($conn , $change_pass_query) ){
                        session_unset();
                        session_destroy();
                        echo "<script>
                        $(document).ready(function() {
                            $('#addMsg').text( 'Password Updated successfully! Log in With New Password');
                            $('#linkBtn').attr('href','login.php');
                            $('#linkBtn').text('OK, Understood');
                            $('#modalHead').hide();
                            $('#closeBtn').hide();
                            $('#showModal').modal('show');
                        });
                        </script>";
                    }
                    
                }else{
                    $confirm_passErr = "<p style='color:red'>* Confirm did not matched new Password! </p>";
                }

            }else{
               $old_passErr = " <p style='color:red'>*Sorry! Old Password is Wrong </p> ";
            }
        }
    }
?>


<div style="margin-top:1px">
<div class="login-form-bg h-100">
        <div class="container mt-5 h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                                    <h4 class="text-center">Change Password</h4>
                                    <form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="form-group">
                                            <label >Old Password : </label>
                                            <input type="password" name="old_pass" class="form-control">
                                            <?php echo $old_passErr; ?>
                                        </div>
                                        <div class="form-group">
                                            <label >New Password : </label>
                                            <input type="password" name="new_pass" class="form-control">
                                            <?php echo $new_passErr; ?>

                                        </div>
                                        <div class="form-group">
                                            <label >Confirm Password : </label>
                                            <input type="password" name="confirm_pass" class="form-control">
                                            <?php echo $confirm_passErr; ?>

                                        </div>
                
                                        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group">
                                        <input type="submit" value="Save Changes" class="btn btn-primary w-20 " name="save_changes" >        
                                            </div>
                                            <div class="input-group">
                                                <a href="profile.php" class="btn btn-primary w-20">Close</a>
                                            </div>
                                        </div>
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