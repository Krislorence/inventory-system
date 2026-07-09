<?php
session_start();
include "database.php";

$error = "";

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));

    $sql = "SELECT * FROM users_tb WHERE username='$username' AND pssword='$password' AND fullname='$fullname'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo  "<script>alert('baliw mali username/pass mo!');</script>";
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
                <div class="logo-icon">
                    <img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;">
                </div>
                <h2>Welcome </h2>
                <p>Please sign in.</p>
            </div>

            <form action="login.php" method="POST">
                <div class="input-field">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="username" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="input-field">
                        <label>Fullname</label>
                        <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="fullname" name="fullname" placeholder="Enter your Fullname" required>
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
                    <a href="create.php">Forgot Password?</a>
                </div>

                <button type="submit" name="login_btn" class="login-btn">
                    Login <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="https://www.facebook.com/krislorence.chan">Contact our Admin</a></p>
            
            </div>
        </div>
    </div>
</body>
</html>