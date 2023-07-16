<?php
session_start();
if (!isset($_SESSION['IS_LOGIN'])) {
    header('location: login.php');
    die();
}

// Establish a database connection
$con = mysqli_connect('localhost', 'root', '', 'leave');
if (!$con) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

$res = mysqli_query($con, "SELECT * FROM `employee profile` ORDER BY name DESC");
if (!$res) {
    die("Query execution failed: " . mysqli_error($con));
}
$role = $_SESSION['ROLE'];
$res = mysqli_query($con, "SELECT * FROM `employee profile` WHERE role = $role");


?>
<?php
if ($row = mysqli_fetch_assoc($res)) {
    // Retrieve the data from the row
    $name = $row['name'];
    $ph = $row['ph'];
    $department = $row['department'];
    $employeeID = $row['employeeID'];
    $address = $row['address'];
    $designation = $row['designation'];
    $age = $row['age'];
    $email = $row['email'];
}
?>
<!doctype html>
<html class="no-js" lang="">
<head>
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Profile Page</title>
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
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-header"><strong><h1>Profile</h1></strong></div>
                     <div class="card-body card-block">
                      <?php
   
       ?>
       <form action="process_leave_submission.php" method="POST">
    <!-- Form fields -->
    <table style="margin-left: 20px; width: 80%;">
        <tr>
            <td><label for="name">Name:</label></td>
            <td><input type="text" id="name" name="name" value="<?php echo $name; ?>"></td>
        </tr>
        <tr>
            <td><label for="phnno">Ph no:</label></td>
            <td><input type="text" id="phnno" name="ph" value="<?php echo $ph; ?>"></td>
        </tr>
        <tr>
            <td><label for="department">Department:</label></td>
            <td><input type="text" id="department" name="department" value="<?php echo $department; ?>"></td>
        </tr>
        <tr>
            <td><label for="employeeID">Employee ID:</label></td>
            <td><input type="text" id="employeeID" name="employeeID" value="<?php echo $employeeID; ?>"></td>
        </tr>
        <tr>
            <td><label for="address">Address:</label></td>
            <td><input type="text" id="address" name="address" value="<?php echo $address; ?>"></td>
        </tr>
        <tr>
            <td><label for="designation">Designation:</label></td>
            <td><input type="text" id="designation" name="designation" value="<?php echo $designation; ?>"></td>
        </tr>
        <tr>
            <td><label for="age">Age:</label></td>
            <td><input type="text" id="age" name="age" value="<?php echo $age; ?>"></td>
        </tr>
    </table>
</form>
       <?php
   ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </div>
</body>
</html>
