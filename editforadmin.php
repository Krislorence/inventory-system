<?php
include "db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = mysqli_query($conn, "SELECT * FROM kangkong_tb WHERE id=$id");
$item = mysqli_fetch_assoc($result);
if (!$item) {
    header("Location: inventoryforadmin.php");
    exit();
}

$error = "";

if (isset($_POST['save'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $updated_by = mysqli_real_escape_string($conn, $_POST['updated_by']);
    $last_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE kangkong_tb
            SET item_name='$item_name', 
                category='$category', 
                quantity=$quantity, 
                price=$price, 
                last_updated='$last_updated',
                updated_by='$updated_by'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: inventoryforadmin.php");
        exit();
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="additem.css">
</head>
<body>

    <div class="app-container">
        <main class="main-content">
            <header class="top-bar">
                <div class="user-greeting">
                    <h1>Edit Product</h1>
                    <p style="color: black;">Updating the Product/Item<?= $item['id'] ?></p>
                </div>
            </header>
            <section class="form-card">
                <?php if (!empty($error)): ?>
                    <div class="alert danger">
                        <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="add-form">
                    <div class="form-grid">
                        
                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" id="item_name" name="item_name" value="<?= htmlspecialchars($item['item_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select Category</option>
                                <?php
                                $options = ["Electronics", "Furniture", "Clothing", "Food", "Office", "Other"];
                                foreach ($options as $opt) {
                                    $selected = ($item['category'] == $opt) ? "selected" : "";
                                    echo "<option value='$opt' $selected>$opt</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" min="0" value="<?= $item['quantity']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= $item['price']; ?>" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="updated_by">Updated By</label>
                            <input type="text" id="updated_by" name="updated_by" value="<?= htmlspecialchars($item['updated_by']); ?>" placeholder="Enter your name" required>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" name="save" class="btn-submit">
                         Save
                        </button>
                        <a href="dashboardforadmin.php" class="btn-cancel">Cancel</a>
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