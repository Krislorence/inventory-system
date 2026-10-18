<?php
session_start();
include "db.php";
if (isset($_SESSION['user'])) {
    header("Location: dashboardforadmin.php");
    exit();
}
$error = "";

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    $sql = "SELECT * FROM yosir WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $username;
        header("Location: dashboardforadmin.php");
        exit();
    } else {
        $error = "Enggg Maliiiii ang Username, Fullname, o Password Mooo!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login KRIS Nexus Inventory System</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="login-header">
                <h2>Welcome Admin </h2>
                <p>Please sign in.</p>
            </div>

            <form action="adminloginform.php" method="POST">
                <div class="input-field">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="username" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="input-field">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="login-options">
                    <label><input type="checkbox"> Remember me</label>
                    
                </div>

                <button type="submit" name="login_btn" class="login-btn">
                    Login <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>