<?php
session_start();
require_once "include/header.php";
require_once "../connection.php";

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef8f1;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1250px;
            margin: 0 auto;
            background-color: white;
            padding: 25px;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color:rgb(12, 120, 17);
            margin-bottom: 25px;
        }

        .search-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 8px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 260px;
        }

        .table-responsive {
            overflow-x: auto;
            max-height: 400px;
            border-radius: 6px;
            border: 1px solid #c3e6cb;
        }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }

        th {
            background-color: #28a745;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        tr:nth-child(even) {
            background-color: #e9f7ef;
        }

        tr:hover {
            background-color: #d4edda;
        }

        .action-btn {
    text-decoration: none !important;
    background-color: #28a745;
    color: white !important;
    padding: 8px 14px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    display: inline-block;
}

.action-btn:visited,
.action-btn:focus {
    color: white !important;
    background-color: #28a745;
    text-decoration: none;
}

.action-btn:hover {
    background-color: #218838;
    color: white !important;
}


        .no-data-message {
            text-align: center;
            font-size: 18px;
            color: #dc3545;
            margin-top: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        @media screen and (max-width: 768px) {
            .search-bar {
                justify-content: center;
            }

            .search-bar input {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Employee List</h2>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search" placeholder="Search by name..." onkeyup="filterTable()" />
    </div>

    <?php
    $query = "SELECT * FROM employee";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'><table id='employeeTable'>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            $emp_id = $row['id'];
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['salary']}</td>
                    <td><a href='update_salary.php?id=$emp_id' class='action-btn'>Update Salary</a></td>
                  </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='no-data-message'>No employees found.</p>";
    }
    ?>
</div>

<script>
    function filterTable() {
        const input = document.getElementById('search');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('employeeTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[1];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }
</script>

</body>
</html>

<?php require_once "include/footer.php"; ?>
