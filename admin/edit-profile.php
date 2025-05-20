<?php
    require_once "include/header.php";
?>
<style>
    body {
    background-color: #eafaf1;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #064420;
}

.login-form-bg {
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 128, 0, 0.2);
    padding: 30px 25px;
}

.card.login-form {
    border: none;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0, 128, 0, 0.15);
}

.card-body.pt-5.shadow {
    padding: 2rem 2rem 2.5rem 2rem;
}

h4.text-center {
    color: #2a6a2a;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #2a6a2a;
}

.form-control {
    border: 1.5px solid #28a745;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 1rem;
    color: #064420;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #196619;
    box-shadow: 0 0 8px #7cd67caa;
    outline: none;
}

.form-check-label {
    color: #196619;
    font-weight: 600;
}

.form-check-input {
    cursor: pointer;
}

.btn-primary {
    background-color: #28a745;
    border: none;
    padding: 10px 25px;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 6px;
    transition: background-color 0.3s ease;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
}

.btn-primary:hover, .btn-primary:focus {
    background-color: #196619;
    box-shadow: 0 6px 12px rgba(25, 102, 25, 0.5);
    outline: none;
}

.btn-toolbar {
    margin-top: 1.5rem;
}

.btn-group, .input-group {
    display: inline-block;
}

a.btn-success {
    text-decoration: none;
    color: white;
}

a.btn-success:hover {
    background-color: #196619;
    color: #d4f5d4;
}

/* Responsive small tweaks */
@media (max-width: 576px) {
    .login-form-bg {
        padding: 20px 15px;
    }
}

    </style>

<?php  


        // database connection
        require_once "../connection.php";
        

        $session_email =  $_SESSION["email"];
    $sql = "SELECT * FROM admin WHERE email= '$session_email' ";
    $result = mysqli_query($conn , $sql);

    if(mysqli_num_rows($result) > 0 ){
       
        while($rows = mysqli_fetch_assoc($result) ){
            $name = $rows["name"];
            $email = $rows["email"];
            $dob = $rows["dob"];
            $gender = $rows["gender"];
        }
    }

        $nameErr = $emailErr = "";
        // $name = $email = $dob = $gender = "";

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
                $name = "";
            }else {
                $name = $_REQUEST["name"];
            }

            if( empty($_REQUEST["email"]) ){
                $emailErr = "<p style='color:red'> * Email is required</p> ";
                $email = "";
            }else{
                $email = $_REQUEST["email"];
            }


            if( !empty($name) && !empty($email) ){
            
                $sql_select_query = "SELECT email FROM admin WHERE email = '$email' ";
                $r = mysqli_query($conn , $sql_select_query);

                if( mysqli_num_rows($r) > 0 ){
                    $emailErr = "<p style='color:red'> * Email Already Register</p>";
                } else{

                    $sql = "UPDATE admin SET name = '$name', email = '$email', dob = '$dob', gender= '$gender' WHERE email='$_SESSION[email]' ";
                    $result = mysqli_query($conn , $sql);
                    if($result){
                        $_SESSION['email']= $email;
                        echo "<script>
                            $(document).ready( function(){
                                $('#showModal').modal('show');
                                $('#modalHead').hide();
                                $('#linkBtn').attr('href', 'profile.php');
                                $('#linkBtn').text('View Profile');
                                $('#addMsg').text('Profile Edited Successfully!!');
                                $('#closeBtn').hide();
                            })
                        </script>
                        ";
                    }
                }

            }
        }
?>



<div style=""> 
        <div class="container mt-5 h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5 shadow">                       
                                    <h4 class="text-center">Edit Your Profile</h4>
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


                                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group">
                                   <input type="submit" value="Save Changes" class="btn btn-success w-20 " name="save_changes" >        
                                    </div>
                                    <div class="input-group">
                                         <a href="profile.php" class="btn btn-success w-20">Close</a>
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