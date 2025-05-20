
<?php 
    require_once "include/header.php";
?>

<?php 
 
  $email = $_SESSION["email_emp"];
//  database connection
require_once "../connection.php";

$sql = "SELECT * FROM emp_leave WHERE email = '$email'  ";
$result = mysqli_query($conn , $sql);

$i = 1;

?>
<style>
body {
    background-color: #e9f5ec;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container {
    background-color: #ffffff;
    border-radius: 10px;
    margin-top: 30px;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    max-width: 100%;
}

h4 {
color: #2e7d32;
    font-weight: bold;
    margin-bottom: 25px;
}

/* Scrollable table container */
.table-container {
    max-height: 450px;
    overflow-y: auto;
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background-color: #f8fff9;
}

th, td {
    padding: 14px 16px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
}

th {
    background-color: #43a047;
    color: white;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 1;
}

tr:nth-child(even) {
    background-color: #f1fdf5;
}

tr:hover {
    background-color: #d7f3e4;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #43a047;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    background-color: #388e3c;
}

.fa-trash {
    color: white;
}
</style>
<!-- Bootstrap Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px;">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalLabel">⏳ Leave Reminder</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size: 16px; color: #333;">
        <p id="addMsg" style="margin-bottom: 0;"></p>
      </div>
      <div class="modal-footer">
        <a id="linkBtn" href="#" class="btn btn-success rounded-pill"></a>
        <button type="button" id="closeBtn" class="btn btn-outline-success rounded-pill" data-bs-dismiss="modal"></button>
      </div>
    </div>
  </div>
</div>

<div class="container shadow">
    <div class="py-2 mt-3"> 
        <h4 class="text-center pb-3">Leave Status</h4>
        
        <div class="table-container">
            <table class="table-hover text-center">
                <tr>
                    <th>S.No.</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th> 
                    <th>Total Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php 
                if(mysqli_num_rows($result) > 0){
                    while($rows = mysqli_fetch_assoc($result)){
                        $start_date = $rows["start_date"];
                        $last_date = $rows["last_date"];
                        $email = $rows["email"];
                        $reason = $rows["reason"];
                        $status = $rows["status"]; 
                        $id = $rows["id"];   
                        ?>
                        <tr>
                            <td><?php echo "$i."; ?></td>
                            <td><?php echo date("jS F", strtotime($start_date)); ?></td>
                            <td><?php echo date("jS F", strtotime($last_date)); ?></td>
                            <td>
                                <?php 
                                $date1 = date_create($start_date);
                                $date2 = date_create($last_date);
                                $diff = date_diff($date1, $date2); 
                                echo $diff->format("%a days");
                                ?>
                            </td>
                            <td><?php echo $reason; ?></td> 
                            <td><?php echo $status; ?></td> 
                            <td>
                                <a href='delete-leave.php?id=<?php echo $id; ?>' class='btn-sm btn-primary'>
                                    <i class='fa fa-trash'></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                        $i++;
                    }
                } else {
                    echo "<script>
                        $(document).ready( function(){
                            $('#showModal').modal('show');
                            $('#addMsg').text('No leave Applied by you!!');
                            $('#linkBtn').attr('href', 'apply-leave.php');
                            $('#linkBtn').text('Apply for Leave');
                            $('#closeBtn').text('Remind me Later');
                        });
                    </script>";
                }
                ?>
            </table>
        </div>
    </div>
</div>


<?php 
    require_once "include/footer.php";
?>
