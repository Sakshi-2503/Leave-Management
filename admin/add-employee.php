<?php 
    require_once "include/header.php";
?>

<style>
    body {
        background-color: #eafaf1;
        font-family: Arial, sans-serif;
    }

    .login-form-bg {
        padding-top: 10px;
        padding-bottom: 50px;
    }

    .form-input-content {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 128, 0, 0.2);
    }

    .card {
        border: none;
    }
    h4{
        font-weight: bold;
    }

    h4.text-center {
        margin-bottom: 25px;
        color: #006400; /* dark green */
    }

    .form-group label,
    .form-check-label {
        font-weight: 600;
        color: #006400;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #f9fff9;
    }

    .form-check-inline {
        margin-right: 15px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-weight: bold;
        padding: 10px;
        border-radius: 6px;
        transition: background-color 0.3s;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #218838;
    }

    p[style*="color:red"] {
        margin-top: 5px;
        font-size: 14px;
    }
    /* Modal container */
#showModal .modal-content {
    border-radius: 12px;
    padding: 10px 10px;
    background-color: #eafaf1; /* light greenish background */
    box-shadow: 0 6px 20px rgba(0, 128, 0, 0.25);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Modal message */
#addMsg {
    font-size: 1.3rem;
    font-weight: 600;
    color: #006400; /* dark green */
    margin-bottom: 20px;
    text-align: center;
}

/* Buttons container */
#showModal .modal-footer {
    display: flex;
    justify-content: center;
    gap: 15px;
    padding-top: 10px;
    border-top: none;
}

/* Buttons */
#linkBtn, #closeBtn {
    padding: 10px 22px;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s ease;
    min-width: 130px;
}

/* Link button - green */
#linkBtn {
    background-color: #28a745;
    color: white;
}

#linkBtn:hover {
    background-color: #218838;
}

/* Close button - softer green */
#closeBtn {
    background-color: #a7d7a7;
    color: #064d00;
}

#closeBtn:hover {
    background-color: #7bb37b;
}

/* Hide modal header if needed */
#modalHead {
    display: none;
}

</style>

<?php  

        $nameErr = $emailErr = $passErr = $salaryErr= "";
        $name = $email = $dob = $gender = $pass = $salary = "";

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

            if( empty($_REQUEST["salary"]) ){
                $salaryErr = "<p style='color:red'> * Salary is required</p>";
                $salary = "";
            }else {
                $salary = $_REQUEST["salary"];
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


            if( !empty($name) && !empty($email) && !empty($pass) && !empty($salary) ){

                // database connection
                require_once "../connection.php";

                $sql_select_query = "SELECT email FROM employee WHERE email = '$email' ";
                $r = mysqli_query($conn , $sql_select_query);

                if( mysqli_num_rows($r) > 0 ){
                    $emailErr = "<p style='color:red'> * Email Already Register</p>";
                } else{

                    $sql = "INSERT INTO employee( name , email , password , dob, gender , salary ) VALUES( '$name' , '$email' , '$pass' , '$dob' , '$gender', '$salary' )  ";
                    $result = mysqli_query($conn , $sql);
                    if($result){
                     $name = $email = $dob = $gender = $pass = $salary = "";
                        echo "<script>
                        $(document).ready( function(){
                            $('#showModal').modal('show');
                            $('#modalHead').hide();
                            $('#linkBtn').attr('href', 'manage-employee.php');
                            $('#linkBtn').text('View Employees');
                            $('#addMsg').text('Employee Added Successfully!');
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
        <div class="container  h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                                    <h4 class="text-center font-bold">Add New Employee</h4>
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
                                    <label >Salary :</label>
                                    <input type="number" class="form-control" value="<?php echo $salary; ?>" name="salary" >  
                                    <?php echo $salaryErr; ?>            
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

                                <button type="submit" class="btn btn-success  btn-block">Add</button>
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


