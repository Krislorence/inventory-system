<?php
include "db.php";

if(isset($_POST['save'])) {
    $itemname = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $lastupdate = date('Y-m-d H:i:s');
    $updated_by = mysqli_real_escape_string($conn, $_POST['updated_by']);

    $sql = "INSERT INTO kangkong_tb(item_name, category, quantity, price, last_updated, updated_by) 
            VALUES('$itemname', '$category', $quantity, $price, '$lastupdate', '$updated_by')";
    
    if(mysqli_query($conn, $sql)) {
        $success = "Item added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kangkong_tb"))['count'] ?? 0;
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kangkong_tb WHERE quantity <= 5"))['count'] ?? 0;
$outOfStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kangkong_tb WHERE quantity = 0"))['count'] ?? 0;
$totalValue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(quantity * price) as total FROM kangkong_tb"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INventory system</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div>
                <div class="brand-logo">
                    <h2>Inventory System</h2>
                </div>

                <a href="additemforadmin.php" class="btn-new-item">
                    <i class="fa-solid fa-plus"></i> New Item
                </a>

                <ul class="nav-menu">
                    <li>
                        <a href="dashboardforadmin.php" class="nav-link active">
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
                        <a href="viewregisteruser.php" class="nav-link">
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

            <div>
                <div class="sidebar-widget">
                    <p><strong>System Status</strong></p>
                    <p class="widget-sub">All services operational.</p>
                </div>

                <a href="register.php" class="logout-link" onclick="return confirm('segurado kana dyan?')">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log out
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="user-greeting">
                    <h1>Admin Dashboard Overview</h1>
                    <p style="color: black;"><?= date('F d, Y') ?></p>
                </div>
            </header>

            <section class="stats-banner" style="background-color: white;">
                <div class="stat-item">
                    <span class="stat-label">Total Products</span>
                    <div class="stat-value"><?= number_format($totalProducts) ?></div>
                    <span class="stat-desc">Registered items</span>
                </div>

                <div class="stat-item">
                    <span class="stat-label">Low Stock</span>
                    <div class="stat-value"><?= number_format($lowStock) ?></div>
                    <span class="stat-desc">Items</span>
                </div>

                <div class="stat-item">
                    <span class="stat-label">Out of Stock</span>
                    <div class="stat-value"><?= number_format($outOfStock) ?></div>
                    <span class="stat-desc">Items needing restock</span>
                </div>

                <div class="stat-item">
                    <span class="stat-label">Total Value</span>
                    <div class="stat-value">&#8369;<?= number_format($totalValue, 2) ?></div>
                    <span class="stat-desc">Inventory worth</span>
                </div>
            </section>

            <section class="dashboard-grid">
                <div class="quick-card">
                    <div class="card-icon-wrapper">
                        <i class="fa-solid fa-circle-plus"></i>
                    </div>
                    <div class="card-info">
                        <h3>Add New Item</h3>
                        <p>Insert new product</p>
                        <a href="additemforadmin.php" class="action-link">Open Form</a>
                    </div>
                </div>

                <div class="quick-card">
                    <div class="card-icon-wrapper">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div class="card-info">
                        <h3>View Records</h3>
                        <p>Edit items</p>
                        <a href="inventoryforadmin.php" class="action-link">View Table</a>
                    </div>
                </div>

                <div class="quick-card">
                    <div class="card-icon-wrapper">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div class="card-info">
                        <h3>Reports</h3>
                        <p>Reports summary</p>
                        <a href="reportforadmin.php" class="action-link">View Reports</a>
                    </div>
                </div>
            </section>

            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>

        </main>
    </div>

</body>
</html>