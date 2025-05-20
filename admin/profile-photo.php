<?php 
require_once "include/header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<style>
  body {
    background-color: #e6f2e6; /* Light green background */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .login-form-bg {
    background-color: #ffffff; /* white card */
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 128, 0, 0.2);
    padding: 30px 25px;
  }
  .login-form-bg h4 {
    color: #2e7d32; /* dark green heading */
    font-weight: 700;
    margin-bottom: 30px;
  }
  label {
    font-weight: 600;
    color: #2e7d32; /* dark green labels */
  }
  .form-control {
    border: 2px solid #a5d6a7; /* soft green border */
    border-radius: 8px;
    padding: 10px 12px;
    transition: border-color 0.3s ease;
  }
  .form-control:focus {
    border-color: #388e3c; /* darker green on focus */
    box-shadow: 0 0 5px #66bb6a;
    outline: none;
  }
  .btn-success {
    background-color: #388e3c;
    border: none;
    font-weight: 600;
    padding: 10px 25px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }
  .btn-success:hover {
    background-color: #2e7d32;
  }
  .btn-success:focus, .btn-primary:active {
    background-color: #1b5e20;
    box-shadow: 0 0 8px #1b5e20;
  }
  .btn-group, .input-group {
    margin-top: 15px;
  }
  /* Responsive */
  @media (max-width: 576px) {
    .col-xl-6 {
      max-width: 90% !important;
      margin: auto;
    }
  }

  /* Modal background */
  #showModal .modal-content {
    background-color: #f9fff9; /* very light greenish-white */
    border-radius: 12px;
    border: 2px solid #388e3c; /* dark green border */
  }
  
  /* Modal header, hide if needed */
  #showModal .modal-header {
    color: white;
    border-bottom: none;
    border-radius: 12px 12px 0 0;
    font-weight: 700;
  }

  /* Modal body message */
  #addMsg {
    color: #2e7d32; /* dark green text */
    font-weight: 600;
    font-size: 1.1rem;
    text-align: center;
    padding: 15px 20px;
  }
  
  /* Buttons in modal */
  #showModal .btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 8px 20px;
    min-width: 100px;
    transition: background-color 0.3s ease;
  }

  #linkBtn {
    background-color: #388e3c; /* green */
    color: white !important;
    border: none;
  }
  #linkBtn:hover {
    background-color: #2e7d32;
    color: white !important;
  }
  
  #closeBtn {
    background-color: #a5d6a7; /* lighter green */
    color: #2e7d32 !important;
    border: none;
    margin-left: 10px;
  }
  #closeBtn:hover {
    background-color: #81c784;
    color: white !important;
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
                $sql = " UPDATE admin SET dp = '$new_file_name' WHERE email = '$_SESSION[email]' ";
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