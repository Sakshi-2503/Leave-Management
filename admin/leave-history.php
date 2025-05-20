<?php 
require_once "include/header.php";
require_once "../connection.php";

// Query for Accepted Leaves
$sql_accepted = "SELECT * FROM emp_leave WHERE status = 'Accepted'";
$result_accepted = mysqli_query($conn, $sql_accepted);

// Query for Canceled Leaves
$sql_canceled = "SELECT * FROM emp_leave WHERE status = 'Canceled'";
$result_canceled = mysqli_query($conn, $sql_canceled);
?>

<style>
    body {
        background-color: #eafaf1;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        background-color: #ffffff;
        margin-top: 0px;
        border-radius: 10px;
        padding: 30px 25px;
        box-shadow: 0 5px 15px rgba(0, 128, 0, 0.15);
    }

    h4 {
        color: #006400;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Scrollable Table Container */
    .table-scroll {
        max-height: 300px; /* Adjust height as needed */
        overflow-y: auto;
        margin-bottom: 40px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px; /* vertical spacing between rows */
        margin: 0; /* no extra margin inside scroll */
    }

    thead tr {
        border-radius: 8px;
        position: sticky;
        top: 0;
        background-color: inherit; /* fallback */
        z-index: 10;
    }

    th, td {
        text-align: center;
        padding: 14px 12px;
        vertical-align: middle;
        border: none; /* no cell borders */
        background-color: #f9fff9;
    }

    thead.bg-dark th {
        background-color: #006400;
        color: white;
        font-weight: 700;
        border-radius: 8px 8px 0 0;
    }

    thead.bg-danger th {
        background-color: #dc3545;
        color: white;
        font-weight: 700;
        border-radius: 8px 8px 0 0;
    }

    tbody tr:hover td {
        background-color: #dff0e1;
    }

    /* Rounded corners on rows */
    tbody tr td:first-child {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    tbody tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
</style>

<div class="container bg-white shadow p-1 mt-1">
    <h4 class="text-center mb-2">Accepted Leave Requests</h4>
    <div class="table-scroll">
        <table class="table text-center">
            <thead class="bg-dark text-white">
                <tr>
                    <th>S.No.</th>
                    <th>Employee Email</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                while($row = mysqli_fetch_assoc($result_accepted)) {
                    $days = date_diff(date_create($row['start_date']), date_create($row['last_date']))->format("%a days");
                    echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['email']}</td>
                        <td>" . date("jS F", strtotime($row['start_date'])) . "</td>
                        <td>" . date("jS F", strtotime($row['last_date'])) . "</td>
                        <td>{$days}</td>
                        <td>{$row['reason']}</td>
                    </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <h4 class="text-center mt-1 mb-1">Canceled Leave Requests</h4>
    <div class="table-scroll">
        <table class="table text-center">
            <thead class="bg-danger text-white">
                <tr>
                    <th>S.No.</th>
                    <th>Employee Email</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $j = 1;
                while($row = mysqli_fetch_assoc($result_canceled)) {
                    $days = date_diff(date_create($row['start_date']), date_create($row['last_date']))->format("%a days");
                    echo "<tr>
                        <td>{$j}</td>
                        <td>{$row['email']}</td>
                        <td>" . date("jS F", strtotime($row['start_date'])) . "</td>
                        <td>" . date("jS F", strtotime($row['last_date'])) . "</td>
                        <td>{$days}</td>
                        <td>{$row['reason']}</td>
                    </tr>";
                    $j++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
require_once "include/footer.php";
?>
