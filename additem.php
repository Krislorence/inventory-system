<?php
include "db.php" ;
$success = $error = "";


if ($_POST) {
    $item_name = mysqli_real_escape_string($conn, trim($_POST['item_name']));
    $category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $last_updated = date('Y-m-d H:i:s');
    $updated_by = mysqli_real_escape_string($conn, trim($_POST['updated_by']));

    
    if (empty($item_name) || empty($category) || $quantity < 0 || $price < 0 || $updated_by < 0) {
        $error = "Please fill all fields correctly!";
    } else {
        $sql = "INSERT INTO kongkong_tb (item_name, category, quantity, price, last_updated, updated_by) 
                VALUES ('$item_name', '$category', '$quantity', '$price', '$last_updated', '$updated_by' )";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Item '$item_name' added successfully! 🎉";
            $_POST = []; 
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
    <title>Add Item Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="additem.css">
</head>
<body>
    
    
    <main class="main-content">
       
        <header class="page-header">
            <div class="header-content">
                <h1><img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;"> Add Item</h1>
                <p>Please Fill the form below to add item in our inventory system</p>
            </div>
            <div class="header-actions">
                <a href="view.php" class="btn-secondary">
                    <i class="fas fa-list"></i> View Records
                </a>
                <a href="index.php" class="btn-primary">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </header>

       
        <div class="form-container">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= $success ?>
                    
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="add-form" novalidate>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item_name">
                            <i class="fas fa-box"></i>Item Name
                        </label>
                        <input type="text" name="item_name" placeholder="Enter item name" required>
                        
                    </div>

                    <div class="form-group">
                        <label for="category">
                            <i class="fas fa-tag"></i>Category
                        </label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Electronics" >📱 Electronics</option>
                            <option value="Furniture" >🛋️ Furniture</option>
                            <option value="Clothing" >👕 Clothing</option>
                            <option value="Food" >🍎 Food</option>
                            <option value="Office" >📋 Office</option>
                            <option value="Other" >📦 Other</option>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label for="quantity">
                            <i class="fas fa-layer-group"></i>Quantity/Stock
                        </label>
                        <input type="number" name="quantity" placeholder="0" required>
                        
                    </div>

                    <div class="form-group">
                        <label for="price">
                            <i class="fas fa-dollar-sign"></i>Price (₱)
                        </label>
                        <input 
                            type="number" name="price" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="form-group">
                        <label for="last_update">
                            <i class="fas fa-dollar-sign"></i> Last Update
                        </label>
                        <input type="date" name="last_update" required>
                        
                    </div>

                     <div class="form-group">
                        <label for="updated_by">
                            <i class="fas fa-user-circle"></i> Updated By
                        </label>
                        <input type="name" name="updated_by" required>
                        
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="save" class="btn-primary">
                        <i class="fas fa-save"></i>
                        <span class="btn-text">Add Item</span>
                        <div class="btn-loader"></div>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="page-footer">
        <p>&copy; 2026 CCDI LEGAZPI BSIT2D Finals<br>
        BY: Kris Lorence L.Chan, Cj Maquiñana, Jonh Micheal Llaguno, John Cardel, Mark Abellano</p>
    </footer>
</body>
</html>