<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (empty($_SESSION["email_emp"])) {
        header("Location: ./login.php");
        exit();
    }
}

// Fetch user name from session or database
$email_emp = $_SESSION["email_emp"];

// Optional: If you want to show the name from DB instead of email
include '../connection.php'; // update with your DB connection file
$sql = "SELECT name, dp FROM employee WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email_emp);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$name = $userData ? ucwords($userData["name"]) : $email_emp;
$dp = $userData && !empty($userData['dp']) ? $userData['dp'] : 'default.png';
$photoPath = "../employee/upload/$dp";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> Employee Management System</title>
    
    <link href="../resorce/css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>

    <style> 
     .hidden {
         display: none;
     }
     .nav-header {
    background-color: #28a745; /* removes blue background */
}

    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

     





    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        <!-- ***********************************-->
        <div class="nav-header">

             <div class="brand-logo">
                <a >
                    <span class="brand-title">
                   
                    </span>
                </a>
            </div> 
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content ">
              <div class="float-right pr-3 pt-3 d-flex align-items-center">
    <a href="./profile.php" title="Go to Profile">
        <img src="<?php echo $photoPath; ?>" class="rounded-circle" alt="Profile Picture" 
             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #28a745; margin-right: 10px;">
    </a>
    <strong>Welcome, <?php echo htmlspecialchars($name); ?></strong>
</div>


                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
               <div class="text-center">
                <h2 class="pt-3"> Employee Management System </h2>
                 </div>
                
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                   <br> <br>       
                    <li>
                        <a href="./dashboard.php"  >
                            <i class="icon-home menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="./leave-status.php" >
                            <i class="fa fa-tasks menu-icon"></i><span class="nav-text">Leave Status</span>
                        </a>
                    </li>

                    <li>
                        <a href="./apply-leave.php" >
                            <i class="fa fa-paper-plane menu-icon"></i><span class="nav-text">Apply for Leave</span>
                        </a>
                    </li>

                    <li>
                        <a href="./view-employee.php" >
                            <i class="fa fa-list-ul menu-icon"></i><span class="nav-text">View All Employees</span>
                        </a>
                    </li>
                    <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card-o menu-icon"></i><span class="nav-text">Attendance</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./mark_attendance.php"> <i class="icon-plus menu-icon"></i><span class="nav-text">My Today's</span></a></li>
                            <li><a href="./employee_attendance_history.php"> <i class="fa fa-tasks menu-icon"></i><span class="nav-text">My Attendance History</span></a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="./logout.php" >
                            <i class="icon-logout menu-icon"></i><span class="nav-text">Logout</span>
                        </a>
                    </li>
                    <li>
                        <a href="./profile.php"  >
                         
                            <i class="fa fa-user menu-icon"></i><span class="nav-text">Profile</span>
                        </a>
                    </li>                 
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">



        <div class="modal fade" id="showModal" data-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="modalHead" class="modal-header">
                    <button id="modal_cross_btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p id="addMsg" class="text-center font-weight-bold"></p>
                </div>
                <div class="modal-footer ">
                    <div class="mx-auto">
                        <a type="button" id="linkBtn" href="#" class="btn btn-primary" >Add Expense For the Day</a>
                        <a type="button" id="closeBtn" href="#" data-dismiss="modal" class="btn btn-primary">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
            <!-- row -->

            <div class="container-fluid">

            