<?php
session_start();
if (!isset($_SESSION['IS_LOGIN'])) {
    header('location:login.php');
    die();
}

// Establish database connection
$con = mysqli_connect("localhost", "root", "", "leave");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the role of the logged-in user
$role = $_SESSION['ROLE'];

// Modify the query to join the tables and filter by role
$query = "SELECT submissionform.*, `employee profile`.role 
          FROM submissionform submissionform 
          JOIN `employee profile` `employee profile` ON submissionform.role = `employee profile`.role
          WHERE `employee profile`.role = $role 
          ORDER BY submissionform.id DESC";
$res = mysqli_query($con, $query);

if (!$res) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Dashboard Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body>
      <aside id="left-panel" class="left-panel">
         <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
               <ul class="nav navbar-nav">
                  <li class="menu-title">Menu</li>
                  <li class="menu-item-has-children dropdown">
                     <a href="index.php" > Dashboard</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="profile.php" > Profile</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="leaveforms.php" > Leave Request Submission</a>
                  </li>
                  <?php if($_SESSION['ROLE']==1){ ?>

                  <li class="menu-item-has-children dropdown">
                     <a href="leaveapproval.php" > Leave Approval</a>
                  </li>
                  <?php } ?>

               </ul>
            </div>
         </nav>
      </aside>
      <div id="right-panel" class="right-panel">
         <header id="header" class="header">
            <div class="top-left">
               <div class="navbar-header">
                  <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
                  <a class="navbar-brand hidden" href="index.html"><img src="images/logo2.png" alt="Logo"></a>
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
               </div>
            </div>
            <div class="top-right">
               <div class="header-menu">
                  <div class="user-area dropdown float-right">
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $_SESSION['USER_NAME']?></a>
                     <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
        
         
         <div class="content pb-0">
         <div class="animated fadeIn">

            <div class="card-header"><strong><h1>Dashboard</h1></strong></div>
            <div class="content pb-0">
               
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="content pb-0">
                        <div class="welcome-message">
                           <p>Welcome <?php echo $_SESSION['USER_NAME']?> </p>
                           <p>Department: <?php echo isset($_SESSION['DEPT']) ? $_SESSION['DEPT'] : 'Unknown';?></p>
                           
                        </div>
                     </div>
                     <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                           <table class="table">
                              <thead>
                                 <tr>
                                    <th class="serial">#</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type of leave</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody id="data-body">
                                 <?php 
                                    $i = 1;
                                    while($row = mysqli_fetch_assoc($res)){
                                 ?>
                                 <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['Id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['fromdate']; ?></td>
                                    <td><?php echo $row['todate']; ?></td>
                                    <td><?php echo $row['leave_purpose']; ?></td>
                                    
                                    <td>
   <?php if ($row['pos'] == 1) { ?>
      <span class="badge badge-complete">Accepted</span>
   <?php } elseif ($row['pos'] == 2) { ?>
      <span class="badge badge-rejected" style="background-color: #d93e36; color: #fff;">Rejected</span>
   <?php } else { ?>
      <span class="badge badge-pending" style="background-color: #4a63f0; color: #fff;">Pending</span>
   <?php } ?>
</td>


                                    </td>
                                 </tr>
                                 <?php 
                                    $i++;
                                    } 
                                 ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                                 </div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>
