<?php 
require_once "include/header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<style>
  body {
  background-color: #e9f5ee; /* light mint background */
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #2e7d32; /* dark green text */
}

h4.text-center {
  color: #2e7d32;
  font-weight: 700;
  margin-bottom: 25px;
}

label {
  color: #388e3c; /* medium green */
  font-weight: 600;
  display: block;
  margin-bottom: 8px;
}

input.form-control[type="file"] {
  border: 1.5px solid #81c784; /* lighter green border */
  border-radius: 6px;
  padding: 8px 12px;
  font-size: 15px;
  background-color: #f5fbf6; /* very light green background */
  color: #2e7d32;
  transition: border-color 0.3s ease;
}

input.form-control[type="file"]:focus {
  border-color: #4caf50; /* bright green on focus */
  outline: none;
  background-color: #ffffff;
}

.btn-primary {
  background-color: #388e3c;
  border-color: #388e3c;
  color: white;
  padding: 10px 25px;
  font-size: 15px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #2e7d32;
  border-color: #2e7d32;
}

.btn-toolbar {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.card.login-form {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
}

.card-body {
  padding: 30px 30px 20px;
}

</style>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
            $filename = $_FILES["dp"]['name'];
            $temp_loc = $_FILES["dp"]["tmp_name"];

            $temp_ex = explode("." , $filename);
            $extension = strtolower( end($temp_ex) );
            $allowed_types = array("png","jpg","jpeg");

        if( in_array($extension , $allowed_types)  ){
            $new_file_name = uniqid("",true).$filename;
            $location = "upload/".$new_file_name;
            if(move_uploaded_file($temp_loc, $location)){
                
                // database connection 
                require_once "../connection.php";
                $sql = "UPDATE employee SET dp = '$new_file_name' WHERE email = '$_SESSION[email_emp]' ";
                $result = mysqli_query($conn , $sql);
                if($result){
                    echo "<script>
                    $(document).ready( function(){
                        $('#showModal').modal('show');
                        $('#addMsg').text('Profile Photo Update Succefully!!');
                        $('#linkBtn').attr('href', 'profile.php');
                        $('#linkBtn').text('Check Profile');
                        $('#closeBtn').text('Upload Again');
                    })
                </script>
                ";
                }
                
            }
        } else{ echo "<script>
            $(document).ready( function(){
                $('#showModal').modal('show');
                $('#addMsg').text('Only JPG, PNG and JPEG files allowed!!');
                $('#linkBtn').attr('href', 'profile.php');
                $('#linkBtn').hide();
                $('#closeBtn').text('Ok, Understood');
            })
        </script>
        ";
         
        }
}
?>


<div style="margin-top:100px"> 
<div class="login-form-bg h-100">
        <div class="container mt-5 h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5 shadow">                       
                                    <h4 class="text-center">Change Profile photo</h4>
                                    <form method="POST" enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="form-group">
                                            <label >Select Image : </label>
                                            <input type="file" name="dp" class="form-control">
                                           
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