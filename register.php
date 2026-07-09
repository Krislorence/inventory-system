<?php
include "database.php";

$success = $error = "";

if (isset($_POST['register_btn'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
     $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    
    if (empty($username) || empty($password) || empty($fullname)) {
        $error = "Please fill all fields!";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users_tb WHERE username='$username' AND pssword='$password' AND fullname='$fullname'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username already exists!";
        } else {
            $sql = "INSERT INTO users_tb (username, pssword, fullname) VALUES ('$username', '$password', '$fullname')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Registered successfully!'); window.location='login.php';</script>";
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratoin Form</title>
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
                <h2>Create Your Account</h2>
                <p>Welcome to KRIS Nexus Inventory.</p>
            </div>

            <form action="register.php" method="POST">
                <div class="input-field">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="username" placeholder="Choose a username" required>
                    </div>
                </div>

                <div class="input-field">
                    <label>Fullname</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="fullname" name="fullname" placeholder="Enter Fullname" required>
                    </div>
                </div>

                <div class="input-field">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="Create a password" required>
                    </div>
                </div>

                <div class="input-field">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="Repeat your password" required>
                    </div>
                </div>

                <button type="submit" name="register_btn" class="login-btn">
                    Register Now <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>

            <div class="login-footer">
                <p>Already have an account?</p> <a href="login.php">SignIn as User</a><p> </p>
                <a href="adminloginform.php">SignIn as Admin</a>
            </div>
        </div>
    </div>
   
</body>

</html>