<?php
session_start();
if (!isset($_SESSION['IS_LOGIN'])) {
    header('location: login.php');
    die();
}

// Establish database connection
$con = mysqli_connect("localhost", "root", "", "leave");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$res = mysqli_query($con, "SELECT * FROM submissionform ORDER BY id DESC");

// Check if the total number of rows exceeds 50
if (mysqli_num_rows($res) > 50) {
    // Determine the number of rows to delete
    $rowsToDelete = mysqli_num_rows($res) - 50;

    // Delete the older rows
    $deleteQuery = "DELETE FROM submissionform ORDER BY id ASC LIMIT $rowsToDelete";
    $deleteResult = mysqli_query($con, $deleteQuery);
    if (!$deleteResult) {
        // Handle delete error
        die('Deletion failed');
    }

    // Refetch the rows after deletion
    $res = mysqli_query($con, "SELECT * FROM submissionform ORDER BY id DESC");
}

// Handle accept or reject action
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Update the "pos" column based on the action
    if ($action === 'accept') {
        $pos = 1;
    } elseif ($action === 'reject') {
        $pos = 2;
    } else {
        // Handle invalid action
        die('Invalid action');
    }

    $query = "UPDATE submissionform SET pos = $pos WHERE Id = $id";
    $result = mysqli_query($con, $query);
    if (!$result) {
        // Handle update error
        die('Update failed');
    }
}

?>


<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Leave Approval Page</title>
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
      <style>
         .table {
            margin-top: 20px;
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            background-color: #ffffff;
            border: 1px solid #e0e6ed;
         }

         .table th,
         .table td {
            padding: 10px;
            vertical-align: middle;
            border-top: 1px solid #e0e6ed;
            text-align: center;
         }

         .table th {
            font-weight: 700;
            background-color: #f5f6fa;
         }

         .table th:nth-child(8),
         .table td:nth-child(8) {
            text-align: left;
         }

         .table td button {
            padding: 6px 12px;
            font-size: 14px;
         }

         .table td a.bold-option {
         font-weight: bold;
          color: #333333; /* Adjust the color code to the desired darker black shade */
            }

         

      </style>
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
                  <?php if ($_SESSION['ROLE'] == 1) { ?>
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
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $_SESSION['USER_NAME']; ?></a>
                     <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <div class="content pb-0">
            <div class="card-header"><strong><h1>Leave Approval</h1></strong></div>
            <div class="content pb-0">
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div class="card">
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
                                    <th>Description</th>
                                    <th class="text-center">Action</th> <!-- New column -->
                                 </tr>
                              </thead>
                              <tbody id="data-body">
                                 <?php 
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) {
                                 ?>
                                 <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['Id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['fromdate']; ?></td>
                                    <td><?php echo $row['todate']; ?></td>
                                    <td><?php echo $row['leave_purpose']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td>
  <a href="update_status.php?id=<?php echo $row['pos']; ?>&action=accept" <?php echo ($row['pos'] == 1) ? 'class="bold-option"' : ''; ?>>Accept</a>
  <a href="update_status.php?id=<?php echo $row['pos']; ?>&action=reject" <?php echo ($row['pos'] == 2) ? 'class="bold-option"' : ''; ?>>Reject</a>
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
         <div class="clearfix"></div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
      <script>
         // Redirect to the leave page
         function redirectToLeavePage(id) {
            // Modify the URL below according to your leave page's URL
            window.location.href = "leave_page.php?id=" + id;
         }
      </script>
   </body>
</html>
