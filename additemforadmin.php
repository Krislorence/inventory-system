<?php
include "db.php";
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = mysqli_real_escape_string($conn, trim($_POST['item_name'] ?? ''));
    $category = mysqli_real_escape_string($conn, trim($_POST['category'] ?? ''));
    $quantity = (int)($_POST['quantity'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $last_updated = date('Y-m-d H:i:s');
    $updated_by = mysqli_real_escape_string($conn, trim($_POST['updated_by'] ?? ''));
    if (empty($item_name) || empty($category) || empty($updated_by) || $quantity < 0 || $price < 0) {
        $error = "Please fill all required fields correctly!";
    } else {
        $sql = "INSERT INTO kriskong_tb (item_name, category, quantity, price, last_updated, updated_by) 
                VALUES ('$item_name', '$category', $quantity, $price, '$last_updated', '$updated_by')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Item '$item_name' added na!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="additem.css">
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div>
                <a href="additem.php" class="btn-new-item-active">
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
                        <a href="viewregisteruser.php" class="nav-link">
                            <i class="fas fa-users-cog"></i> User Management
                        </a>
                    </li>
                    <li>
                        <a href="settingsforadmin.php" class="nav-link">
                            <i class="fa-solid fa-gear"></i>
                            Accout Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="sidebar-widget">
                    <p><strong>System Status</strong></p>
                    <p class="widget-sub">All services operational.</p>
                </div>

                <a href="logout.php" class="logout-link" onclick="return confirm('Sigurado kana dyan??')">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log out
                </a>
            </div>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <div class="user-greeting">
                    <h1>Add New Product</h1>
                    <p style="color: black;">Fill in the form below to add new item to the inventory</p>
                </div>

                <div class="header-actions">
                    <a href="view.php" class="btn-secondary"> View Records
                    </a>
                </div>
            </header>
            <section class="form-card">
                
                <?php if ($success): ?>
                    <div class="alert success">
                        <i class="fa-solid fa-circle-check"></i>
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="add-form">
                    <div class="form-grid">
                        
                        <div class="form-group">
                            <label for="item_name">
                            Item Name
                            </label>
                            <input type="text" id="item_name" name="item_name" placeholder="Enter item name" required>
                        </div>

                        <div class="form-group">
                            <label for="category">
                            Category
                            </label>
                            <select id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Electronics">📱 Electronics</option>
                                <option value="Furniture">🛋️ Furniture</option>
                                <option value="Clothing">👕 Clothing</option>
                                <option value="Food">🍎 Food</option>
                                <option value="Office">📋 Office</option>
                                <option value="Other">📦 Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity">
                                Quantity
                            </label>
                            <input type="number" id="quantity" name="quantity" min="0" placeholder="0" required>
                        </div>

                        <div class="form-group">
                            <label for="price">
                            Price
                            </label>
                            <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="updated_by">
                            Updated By
                            </label>
                            <input type="text" id="updated_by" name="updated_by" placeholder="Enter your name" required>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" name="save" class="btn-submit">
                        Save Item
                        </button>
                        <a href="view.php" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </section>

            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>
        </main>
    </div>

</body>
</html>