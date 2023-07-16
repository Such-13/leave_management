<?php 
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con = new mysqli("localhost", "root", "", "leave");

    if ($con->connect_error) {
        die("Failed to connect: " . $con->connect_error);
    } else {
        $stmt = $con->prepare("SELECT * FROM `employee profile` WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $row = mysqli_fetch_assoc($stmt_result);
            $_SESSION['ROLE'] = $row['role'];
            $_SESSION['USER_NAME'] = $row['name'];
            $_SESSION['DEPT'] = $row['department'];

            $_SESSION['IS_LOGIN'] = 'yes';

            if ($row['role'] == 1) {
                header('location:index.php');
                die();
            } elseif ($row['role'] != 1) {
                header('location:index.php');
                die();
            }
        } else {
            echo "<h2>Invalid Email or password.</h2>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <style>
        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .logo-big {
            width: 200px;
            height: 110px;
            display: block;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }

        /* Media queries */
        @media (max-width: 768px) {
            .card {
                width: 90%;
            }
        }

        @media (max-width: 576px) {
            .card {
                width: 100%;
                box-shadow: none;
            }

            .logo-big {
                width: 150px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    <div class="text-center mb-4">
                        <img src="MCL.jpg" alt="MCL Logo" class="logo-big">
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password" />
                        </div>
                        <input type="submit" class="btn btn-primary" value="Login" name="submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
