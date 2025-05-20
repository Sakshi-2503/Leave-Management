<?php 
    require_once "include/header.php";
    require_once "../connection.php";

    $sql = "SELECT * FROM employee";
    $result = mysqli_query($conn , $sql);

    $i = 1;
?>

<style>
    body {
        background-color: #f4fdf6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 95%;
        margin: 20px auto;
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
    }

    h4.text-center {
        color: #2e7d32;
        font-weight: bold;
    }

    /* Scroll wrapper for horizontal scrolling */
    .scrollable-table-wrapper {
        display: block;             /* Ensures block layout for scroll */
        overflow-x: auto;
        max-height:400px;
        max-width: 100%;
        border-radius: 5px;
        margin-top: 20px;
        box-shadow: 0 2px 6px rgba(46, 125, 50, 0.15);
    }

    table {
        width: 100%;
        min-width: 1000px; /* Table wider than container to enable scroll */
        max-width: 100%;   /* Prevent overflow outside container */
        border-collapse: separate;
        border-spacing: 0;
    }

    th, td {
        border: 1px solid #a5d6a7;
        padding: 12px 15px;
        text-align: center;
        color: #2e7d32;
        font-size: 15px;
        white-space: nowrap; /* Prevent text wrapping */
    }

    th {
        position: sticky;
        top: 0;
        z-index: 10; /* Higher z-index for sticky header */
        background-color: #2e7d32;
        color: white;
        font-weight: 600;
    }


    tr:hover {
        background-color: #dcedc8;
    }

    .shadow {
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
    }

    .py-4 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .mt-5 {
        margin-top: 3rem;
    }

    .bg-white {
        background-color: #fff;
    }
</style>

<div class="container bg-white shadow">
    <div class="py-4 mt-2"> 
        <h4 class="text-center pb-1">All Employees</h4>

        <!-- Scroll wrapper for the table -->
        <div class="scrollable-table-wrapper">
            <table class="table-hover text-center">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Email</th> 
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0){
                    while($rows = mysqli_fetch_assoc($result)){
                        $name= $rows["name"];
                        $email= $rows["email"];
                        $dob = $rows["dob"];
                        $gender = $rows["gender"];
                        $id = $rows["id"];

                        if($gender == "") $gender = "Not Defined";

                        if($dob == ""){
                            $dob = "Not Defined";
                            $age = "Not Defined";
                        } else {
                            $date1 = date_create($dob);
                            $date2 = date_create("now");
                            $diff = date_diff($date1, $date2);
                            $age = $diff->format("%y Years"); 
                        }

                        if(isset($_SESSION["email_emp"]) && $email == $_SESSION["email_emp"]){
                            $name = "{$name} (You)";
                        }
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $id; ?></td>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td><?php echo htmlspecialchars($gender); ?></td>
                    <td><?php echo htmlspecialchars($dob); ?></td>
                    <td><?php echo htmlspecialchars($age); ?></td>
                </tr>
                <?php 
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No employees found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php 
    require_once "include/footer.php";
?>  
