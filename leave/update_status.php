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
    if ($result) {
        header('location: leaveapproval.php');
    } else {
        // Handle update error
        die('Update failed');
    }
} else {
    // Handle missing id or action
    die('Invalid request');
}
?>
