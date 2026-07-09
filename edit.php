<?php
include "database.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM kongkong_tb WHERE id=$id");
$user = mysqli_fetch_assoc($result);

if (isset($_POST['save'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $last_updated = mysqli_real_escape_string($conn, $_POST['last_update']); 

    $sql = "UPDATE kongkong_tb
            SET item_name='$item_name', 
                category='$category', 
                quantity='$quantity', 
                price='$price', 
                last_updated='$last_updated'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="additem.css">
</head>
<body>
    <main class="main-content">
        <header class="page-header">
            <div class="header-content">
                <h1><i class="fas fa-edit"></i> Edit Item</h1>
                <p>Update/Edit the Item</p>
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
            <form method="POST" class="add-form" novalidate>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item_name"><i class="fas fa-box"></i> Item Name</label>
                        <input type="text" name="item_name" value="<?= htmlspecialchars($user['item_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="category"><i class="fas fa-tag"></i> Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php
                            $options = ["Electronics", "Furniture", "Clothing", "Food", "Office", "Other"];
                            foreach ($options as $opt) {
                                $selected = ($user['category'] == $opt) ? "selected" : "";
                                echo "<option value='$opt' $selected>$opt</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity"><i class="fas fa-count"></i> Quantity</label>
                        <input type="number" name="quantity" value="<?= $user['quantity']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="price"><i class="fas fa-dollar-sign"></i> Price (₱)</label>
                        <input type="number" name="price" step="0.01" value="<?= $user['price']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="last_update">
                            <i class="fas fa-calendar-alt"></i> Last Update
                        </label>
                        <input type="date" name="last_update" 
                               value="<?= date('Y-m-d', strtotime($user['last_updated'])); ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="save" class="btn-primary">
                        <i class="fas fa-save"></i>
                        <span class="btn-text">Submit</span>
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