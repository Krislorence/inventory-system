<?php
include "database.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $search ? "WHERE username LIKE '%$search%' OR password LIKE '%$search%' OR fullname LIKE '%$search%'" : "";
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM userss");
$total_users = ($total_users_query) ? mysqli_fetch_assoc($total_users_query)['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Registered Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="viewregisteruser.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="brand-logo">
                    <h2>Inventory System</h2>
                </div>

                <a href="additemforadmin.php" class="btn-new-item">
                    <i class="fas fa-plus"></i> Add New Item
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
                        <a href="viewregisteruser.php" class="nav-link active">
                            <i class="fas fa-users-cog"></i> User Management
                        </a>
                    </li>
                    <li>
                        <a href="aboutforadmin.php" class="nav-link">
                            <i class="fa-solid fa-circle-info"></i>
                            About Us
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-bottom">
                <a href="login.php" class="logout-link">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <div class="user-greeting">
                    <h1>Registered Users</h1>
                    <p>Manage registered accounts and Checking any bugs in our system</p>
                </div>
                <div class="header-tools">
                    <form method="GET" class="search-box">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search username or fullname...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    
                </div>
            </header>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Registered Accounts</h3>
                        <p><?= $total_users ?></p>
                    </div>
                </div>
            </div>
            <section class="content-card">
                <div class="card-header">
                    <h2>Registered Users</h2>
                </div>
                
                <div class="table-responsive">
                    <table class="my-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM userss $whereClause";
                            $result = mysqli_query($conn, $sql);
                            
                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                                <tr>
                                    <td><strong><?= $row['id']; ?></strong></td>
                                    <td>
                                        <div class="user-cell">
                                            <span><?= htmlspecialchars($row['username']); ?></span>
                                        </div>
                                    </td>
                                    <td><code><?= htmlspecialchars($row['password']); ?></code></td>
                                    <td class="actions">
                                        <a href="deleteadmin.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Sigurado ka ba dyan??')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='4' class='no-data'>no data!.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>
        </main>
    </div>
</body>
</html>