<?php 
    require_once "include/header.php";
?>

<?php 
 
//  database connection
require_once "../connection.php";

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn , $sql);

$i = 1;
$you = "";


?>

<style>
    body {
        background-color: #eafaf1;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        background-color: #ffffff;
        margin-top: 20px;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 5px 15px rgba(0, 128, 0, 0.2);
    }

    h4 {
        color: #006400;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        margin-top: 20px;
    }

    th, td {
        text-align: center;
        padding: 12px;
        vertical-align: middle;
    }

    th {
        background-color: #006400;
        color: white;
        font-weight: bold;
        border: none;
    }

    tr {
        background-color: #f9fff9;
        transition: background-color 0.3s;
    }

    tr:hover {
        background-color: #dff0e1;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .fa-edit, .fa-trash {
        font-size: 16px;
    }
</style>


<div class="container bg-white shadow">
    <div class="py-2 mt-3"> 
    <div class='text-center pb-2'><h4>Manage Admin</h4></div>
    <table style="width:100%" class="table-hover text-center ">
    <tr class="bg-dark">
        <th>S.No.</th>
        <th>Name</th>
        <th>Email</th> 
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Action</th>
    </tr>
    <?php 
    
    if( mysqli_num_rows($result) > 0){
        while( $rows = mysqli_fetch_assoc($result) ){
            $name= $rows["name"];
            $email= $rows["email"];
            $dob = $rows["dob"];
            $gender = $rows["gender"];
            $id = $rows["id"];
            if($gender == "" ){
                $gender = "Not Defined";
            } 

            if($dob == "" ){
                $dob = "Not Defined";
                $age = "Not Defined";
            }else{
                $dob = date('jS F, Y' , strtotime($dob));
                $date1=date_create($dob);
                $date2=date_create("now");
                $diff=date_diff($date1,$date2);
                $age = $diff->format("%Y Years"); 
            }
           
            ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td> <?php echo $name ; ?></td>
        <td><?php echo $email; ?></td>
        <td><?php echo $gender; ?></td>
        <td><?php echo $dob; ?></td>
        <td>   <?php if( $email !== $_SESSION["email"] ){
                $edit_icon = "<a href='edit-admin.php?id= {$id}' class='btn-sm btn-primary float-right ml-3 '> <span ><i class='fa fa-edit '></i></span> </a>";
                $delete_icon = " <a href='delete-admin.php?id={$id}' id='bin' class='btn-sm btn-primary float-right'> <span ><i class='fa fa-trash '></i></span> </a>";
                echo $edit_icon . $delete_icon;
            } else{
                echo "<a href='profile.php' class='btn btn-success float-right'>Profile</a>";
            } ?> 
        </td>

      
        

    <?php 
            $i++;
            }
        }else{
        echo "no admin found";
        }
    ?>
     </tr>
    </table>
    </div>
</div>

<?php 
    require_once "include/footer.php";
?>