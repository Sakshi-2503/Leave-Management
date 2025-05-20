<?php 
    require_once "include/header.php";
?>
<style>
    /* Your existing styles... */
    body {
        background-color: #eafaf1;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        background-color: #ffffff;
        margin-top: 10px;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 5px 15px rgba(0, 128, 0, 0.2);
    }

    h4 {
        color: #006400;
        font-weight: bold;
        text-align: center;
        padding-bottom: 10px;
    }

    .btn-view-history {
        background-color:white;
        color:  #28a745;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
        display: block;
        width: max-content;
        margin-left: 50px;
        text-decoration: none;
        text-align: center;
    }
    .btn-view-history:hover {
        background-color: #218838;
        color: white;
        text-decoration: none;
    }

    /* Rest of your table and button styles ... */

    table {
        width: 100%;
        border-collapse: separate; /* important for spacing */
        border-spacing: 0 10px; /* vertical spacing between rows */
        margin-top: 20px;
    }

    th, td {
        text-align: center;
        padding: 12px;
        vertical-align: middle;
        border: none; /* NO border on cells */
    }

    th {
        background-color: #006400;
        color: white;
        font-weight: bold;
    }

    tr {
        background-color: #f9fff9;
        transition: background-color 0.3s ease;
        border-radius: 8px; /* rounded corners on row background */
    }

    tr:hover {
        background-color: #dff0e1;
    }

    tr td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        margin-right: 6px;
    }

    .btn-outline-primary {
        color: #28a745;
        border: 1.5px solid #28a745;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #28a745;
        color: white;
    }

    .btn-outline-danger {
        color: #dc3545;
        border: 1.5px solid #dc3545;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<?php 
//  database connection
require_once "../connection.php";

$sql = "SELECT * FROM emp_leave WHERE status = 'pending' ";
$result = mysqli_query($conn , $sql);

$i = 1;
?>
<a href="leave-history.php" class="btn-view-history" class="py-4 mt-2">View Leave History</a>

<div class="container bg-white shadow">
    <div class="py-4 mt-2"> 

        <h4 class="text-center pb-3">Leave Requests</h4>

        <!-- New View Leave History button -->

        <table style="width:100%" class="table-hover text-center">
            <tr class="bg-dark">
                <th>S.No.</th>
                <th>Employee Email</th>
                <th>Starting Date</th>
                <th>Ending Date</th> 
                <th>Total Days</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>

            <?php 
            if( mysqli_num_rows($result) > 0){
                while( $rows = mysqli_fetch_assoc($result) ){
                    $start_date= $rows["start_date"];
                    $last_date = $rows["last_date"];
                    $email= $rows["email"];
                    $reason = $rows["reason"];
                    $status = $rows["status"];   
                    $id = $rows["id"]; 
                    ?>
                <tr>
                    <td><?php echo "$i."; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo date("jS F", strtotime($start_date)); ?></td>
                    <td><?php echo date("jS F", strtotime($last_date)); ?></td>
                    <td><?php
                        $date1=date_create($start_date);
                        $date2=date_create($last_date);
                        $diff=date_diff($date1,$date2); 
                        echo $diff->format("%a days");
                    ?></td>
                    <td><?php echo $reason; ?></td> 

                    <td>
                        <?php  
                        echo "<a href='accept-leave.php?id={$id}' class='btn btn-sm btn-outline-primary mr-2'>Accept</a>" ;
                        echo "<a href='cancel-leave.php?id={$id}' class='btn btn-sm btn-outline-danger'>Cancel</a>" ;
                        ?>  
                    </td> 
                </tr>
                <?php 
                $i++;
                }
            } else {
                echo "<script>
                $(document).ready( function(){
                    $('#showModal').modal('show');
                    $('#linkBtn').hide();
                    $('#addMsg').text('No Leave Requests Found');
                    $('#closeBtn').text('Ok, Understood');
                })
                </script>
                ";
            }
            ?>
        </table>
    </div>
</div>

<?php 
    require_once "include/footer.php";
?> 
