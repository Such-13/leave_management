<?php
session_start();
if(!isset($_SESSION['IS_LOGIN'])){
	header('location:login.php');
	die();
}
?>
<?php
$insert = false;
if(isset($_POST['submit']))   
{
 $server = "localhost";
 $username = "root";
 $password = "";
 $dbname = "leave";
 

 $con = mysqli_connect($server , $username , $password, $dbname )  ;

 $role = $_SESSION['ROLE'];


 if(!$con){
      die("Connection to this database failed due to " . mysqli_connect_error() );
 
 }

 
 $name = $_POST['name'];
 $type  = $_POST['leaveType'];
 $from = $_POST['fromDate'];
 $to = $_POST['toDate'];
 $purpose = $_POST['purpose'];
 $description = $_POST['description'];
 

 
 $sql = "INSERT INTO submissionform (name, type, fromdate, todate, leave_purpose, description, role) 
 VALUES ('$name', '$type', '$from', '$to', '$purpose', '$description', '$role')";

  
  

 //echo $sql;
 $insert = true;
 
   mysqli_query($con, $sql);
  
   mysqli_close($con);


}
?>
<!--INSERT INTO `submissionform` (`Sl no`, `Id`, `Name`, `Type of leave`, `From`, `To`, `Purpose`, `Description`) VALUES ('1', 'xxx2023system', 'Haze', 'Earned', '2023-07-13', '2023-07-14', 'Sick', 'Allow me ');
s-->
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>leave forms</title>
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
                        <div class="card-header"><strong><h1>Leave Request Submission Form</h1></strong></div>
                        <div class="card-body card-block">
                           <?php
                           if($insert == true)
                           echo "<p class= 'SumnitMsg' style='color: green;' >Your form has been submitted. </p>"
                           ?>
                           <form action="leaveforms.php" method="POST" >
                              <table style="margin-left: 20px; width: 80%;">
                                 <tr>
                                    <td><label for="name">Name:</label></td>
                                    <td><input type="text" id="name" name="name"  placeholder="Enter your name" ></td>
                                 </tr>
                                 <tr>
                                    <td><label for="leaveType">Type of Leave:</label></td>
                                    <td>
                                       <select id="leaveType" name="leaveType" placeholder="Type of leave">
                                          <option value="earned">Earned Leave</option>
                                          <option value="sick">Sick Leave</option>
                                          <option value="casual">Casual Leave</option>
                                          <option value="restricted">Restricted Leave</option>
                                       </select>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td><label for="fromDate">From:</label></td>
                                    <td><input type="date" id="fromDate" name="fromDate"></td>
                                 </tr>
                                 <tr>
                                    <td><label for="toDate">To:</label></td>
                                    <td><input type="date" id="toDate" name="toDate"></td>
                                 </tr>
                                 <tr>
                                    <td><label for="purpose">Purpose:</label></td>
                                    <td><input type="text" id="purpose" name="purpose" placeholder="Write within 10 words"></td>
                                 </tr>
                                 <tr>
                                 

                                    <tr>
                                       <td colspan="2">
                                          <label for="description">Description:</label>
                                          <textarea id="description" name="description" placeholder="Description" style="height: 300px; width: 100%; margin-top: 10px;"></textarea>
                                       </td>
                                    </tr>


                                 </tr>
                              </table>
                              <br>
                              <button id="submit" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                 <span id="leave">Submit</span>
                                  
                              </button>
                           </form>
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
   </body>
</html>
