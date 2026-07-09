<?php
include "db.php";

if(isset($_POST['save'])) {
    $itemname = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $lastupdate = date('Y-m-d H:i:s');
    $updated_by = mysqli_real_escape_string($conn, $_POST['updated_by']);

    $sql = "INSERT INTO kongkong_tb(item_name, category, quantity, price, last_updated, updated_by) 
            VALUES('$itemname', '$category', $quantity, $price, '$lastupdate', '$updated_by')";
    
    if(mysqli_query($conn, $sql)) {
        $success = "Item added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kongkong_tb"))['count'];
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kongkong_tb WHERE quantity <= 5"))['count'];
$outOfStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kongkong_tb WHERE quantity = 0"))['count'];
$totalValue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(quantity * price) as total FROM kongkong_tb"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    
    <main class="main-kantot">
       
        <header class="dashboard-header">
            <div class="header-content">
                <h1><img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;">KRIS Nexus Inventory</h1>
               
            </div>
            
            
            <div class="stats-pwet">
                <div class="stat-cj total-products">
                    <div class="card-icon">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div class="card-content">
                        <span class="stat-level">Total Products</span>
                        <h2 class="stat-mark"><?= $totalProducts ?></h2>
                    </div>
                    <div class="stat-cardel positive">
                        <i class="fa-solid fa-arrow-up"></i> 12%
                    </div>
                </div>

                <div class="stat-cj low-stock">
                    <div class="card-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div class="card-content">
                        <span class="stat-level">Low Stock</span>
                        <h2 class="stat-mark"><?= $lowStock ?></h2>
                    </div>
                    <div class="stat-cardel warning">
                        <i class="fa-solid fa-exclamation-triangle"></i>
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
                    <div class="stat-cardel danger">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>

                <div class="stat-cj total-value">
                    <div class="card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="card-content">
                        <span class="stat-level">Total Value</span>
                        <h2 class="stat-mark"><?= number_format($totalValue, 2) ?></h2>
                    </div>
                    <div class="stat-cardel positive">
                        <i class="fa-solid fa-arrow-up"></i> 8.2%
                    </div>
                </div>
            </div>
        </header>
        

        
        <section class="quick-actions">
           
        
  
    <div class="action-michael">
    <i class="fas fa-sign-out-alt"></i> 
    <h3>Log out my Account</h3>
    <p>All goods ba?</p>
    
    
    <a href="register.php" 
       class="action-btn secondary" 
       onclick="return confirm('sure na yan?????????')">
       Logout
    </a>
</div>
</div>
            <div class="action-michael">
                <i class="fas fa-plus-circle"></i>
                <h3>Add New Item</h3>
                <p>Add products/items to inventory</p>
                <a href="additem.php" class="action-btn secondary">Add Item</a>
            </div>
            <div class="action-michael">
                <i class="fas fa-eye"></i>
                <h3>View Records</h3>
                <p>Check all inventory items</p>
                <a href="view.php" class="action-btn secondary">View All</a>
            </div>
            <div class="action-michael">
    <i class="fas fa-chart-bar"></i>
    <h3>Reports</h3>
    <p>View Reports</p>
    <a href="viewreports.php" 
       class="action-btn kris">
       View Report
    </a>
</div>
        </section>

       
    </main>
   
    
    <footer class="dashboard-footer">
        <p>&copy; 2026 CCDI LEGAZPI BSIT2D Finals<br>
        BY: Kris Lorence L.Chan, Cj Maquiñana, Jonh Micheal Llaguno, John Cardel, Mark Abellano</p>
    </footer>
    
</body>
</html>