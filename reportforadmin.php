<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kongkong_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kriskong_tb WHERE quantity <= 5 AND quantity > 0"))['count'] ?? 0;
$outOfStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kriskong_tb WHERE quantity = 0"))['count'] ?? 0;
$totalValue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(quantity * price) as total FROM kriskong_tb"))['total'] ?? 0;

$sql = "SELECT id, item_name, category, quantity, price, last_updated, updated_by FROM kriskong_tb";
$result = $conn->query($sql);

$total_value_query = "SELECT SUM(quantity * price) AS total_val FROM kriskong_tb";
$total_result = $conn->query($total_value_query);
$total_row = $total_result->fetch_assoc();

$lowStockItems = mysqli_query($conn, "SELECT item_name, category, quantity, price FROM kriskong_tb WHERE quantity <= 5 AND quantity > 0 ORDER BY quantity ASC");
$outOfStockItems = mysqli_query($conn, "SELECT item_name, category, price FROM kriskong_tb WHERE quantity = 0 ORDER BY item_name ASC");
$topValueItems = mysqli_query($conn, "SELECT item_name, category, quantity, price, (quantity * price) AS total_item_value FROM kriskong_tb ORDER BY total_item_value DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="viewreport.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div>

            <a href="additemforadmin.php" class="btn-new-item">
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
                    <a href="reportforadmin.php" class="nav-link active">
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
            <a href="logout.php" class="logout-link" onclick="return confirm('Sigurado ka bang gusto mong mag-logout?')">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Log out
            </a>
        </div>
    </aside>>
    <main class="main-content">
        
        <header class="main-header">
            <div class="header-text">
                <h1>System Inventory Report</h1>
                <p>Summary report as of <?= date('F d, Y') ?></p>
            </div>
            <div class="header-actions">
                <button class="print-btn" onclick="window.print()">
                    Print Report
                </button>
                <a href="dashboardforadmin.php" class="btn-back">Back</a>
            </div>
        </header>
        <div class="ba-box">
            <div class="card">
                <h3>Registered Items</h3>
                <p><?php echo $result->num_rows; ?></p>
            </div>
            <div class="card">
                <h3>Total Value</h3>
                <p>₱<?php echo number_format($total_row['total_val'] ?? 0, 2); ?></p>
            </div>
        </div>
        <div class="stats-pwet">

            <div class="stat-cj low-stock">
                <div class="card-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="card-content">
                    <span class="stat-level">Low Stock Items</span>
                    <h2 class="stat-mark"><?= $lowStock ?></h2>
                </div>
            </div>

            <div class="stat-cj out-stock">
                <div class="card-icon">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="card-content">
                    <span class="stat-level">Out of Stock</span>
                    <h2 class="stat-mark"><?= $outOfStock ?></h2>
                </div>
            </div>

            <div class="stat-cj total-value">
                <div class="card-icon">
                    <i class="fa-solid fa-peso-sign"></i>
                </div>
                <div class="card-content">
                    <span class="stat-level">Total Asset</span>
                    <h2 class="stat-mark">₱<?= number_format($totalValue, 2) ?></h2>
                </div>
            </div>
        </div>
        <section class="details-grid">
            <div class="details-card">
                <div class="card-header warning">
                    <h3>Low Stock</h3>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Qty Left</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($lowStockItems) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($lowStockItems)): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['item_name']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['category']) ?></td>
                                        <td><span class="badge warning"><?= $row['quantity'] ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="no-data">No low stock items found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="details-card">
                <div class="card-header danger">
                    <h3>Out of Stock List</h3>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($outOfStockItems) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($outOfStockItems)): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['item_name']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['category']) ?></td>
                                        <td><span class="badge danger">Out of Stock</span></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="no-data">No out of stock items.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="details-card">
                <div class="card-header success">
                    <h3>Top 5 Highest Value Items</h3>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total Worth</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($topValueItems) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($topValueItems)): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['item_name']) ?></strong></td>
                                        <td><?= $row['quantity'] ?></td>
                                        <td><strong>₱<?= number_format($row['total_item_value'], 2) ?></strong></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="no-data">No records available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </section>
    </main>
        
</div>

</body>
</html>

<?php $conn->close(); ?>