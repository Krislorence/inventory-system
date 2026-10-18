<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}
include "database.php";

$message = "";
$error = "";
$user_id = $_SESSION['user_id'] ?? 1;
$query = mysqli_query($conn, "SELECT * FROM yuserr WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);
if (isset($_POST['update_profile'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $update_profile = "UPDATE yuserr SET fullname='$fullname', username='$username' WHERE id='$user_id'";
    if (mysqli_query($conn, $update_profile)) {
        $message = "All goods na-update muna ang Profile mo!";
        $user['fullname'] = $fullname;
        $user['username'] = $username;
    } else {
        $error = "Engggggggg Error.";
    }
}
if (isset($_POST['update_password'])) {
    $old_pass = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($old_pass !== $user['password']) {
        $error = "Maliiiiiiii";
    } elseif ($new_pass !== $confirm_pass) {
        $error = "Itama mo nganiii!";
    } else {
        $update_pass = "UPDATE yuserr SET password='$new_pass' WHERE id='$user_id'";
        if (mysqli_query($conn, $update_pass)) {
            $message = "Ayownnn nays oneee!";
            $user['password'] = $new_pass;
        } else {
            $error = "Enggggggg Error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="haha">

                <a href="additem.php" class="btn-new-item">
                    <i class="fa-solid fa-plus"></i> New Item
                </a>

                <ul class="nav-menu">
                    <li>
                        <a href="dashboardforadmin.php" class="nav-link">
                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="inventoryforadmin.php" class="nav-link">
                            <i class="fa-solid fa-box-archive"></i>
                            Inventory Records
                        </a>
                    </li>
                    <li>
                        <a href="reportforadmin.php" class="nav-link">
                            <i class="fa-solid fa-chart-line"></i>
                            Reports
                        </a>
                    </li>
                    
                    <li>
                        <a href="aboutforadmin.php" class="nav-link ">
                            <i class="fa-solid fa-circle-info"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="settingsforadmin.php" class="nav-link active">
                            <i class="fa-solid fa-gear"></i>
                            Account Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <a href="logout.php" class="logout-link" onclick="return confirm('sure kana dyan yah?')">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log out
                </a>
            </div>
        </aside>
        <section class="main-content">
            <div class="main-container">
                <header class="main-header">
                    <h1>Account Settings</h1>
                </header>
                <?php if ($message): ?>
                    <div class="alert-msg alert-success"><i class="fas fa-circle-check"></i> <?= $message ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert-msg alert-danger"><i class="fas fa-triangle-exclamation"></i> <?= $error ?></div>
                <?php endif; ?>

                <div class="settings-grid">
                    <div class="settings-card">
                        <h2> Profile Information</h2>
                        <form action="settings.php" method="POST">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                            </div>
                            <button type="submit" name="update_profile" class="btn-save">
                                 Save Profile
                            </button>
                        </form>
                    </div>
                    <div class="settings-card">
                        <h2> Change Password</h2>
                        <form action="settings.php" method="POST">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="old_password" placeholder="Enter old password" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" name="update_password" class="btn-save">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>
        </section>
        </main>
        
    </div>
</body>
</html>