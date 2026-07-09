<?php
include "db.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $search ? "WHERE item_name LIKE '%$search%' OR category LIKE '%$search%' OR updated_by LIKE '%$search%'" : "";

$countResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM kongkong_tb $whereClause");
$totalRecords = mysqli_fetch_assoc($countResult)['total'];

$sql = "SELECT * FROM kongkong_tb $whereClause ORDER BY last_updated DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="container">
        <header class="main-header">
            <h1><img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;">KRIS Nexus Inventory</h1>
            <div class="header-tools">
                <form method="GET" class="search-box">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <a href="additem.php" class="btn-add">Add New Item</a>
            </div>
        </header>

        <section class="content-section">
            <?php if($totalRecords > 0): ?>
                <table class="my-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Last Updated</th>
                            <th>Updated By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><strong><?= ($row['item_name']) ?></strong></td>
                                <td><?= ($row['category']) ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>₱<?= number_format($row['price'], 2) ?></td>
                                <td><?= date('M j, Y', strtotime($row['last_updated'])) ?></td>
                                <td><?= ($row['updated_by']) ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="edit-link">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Delete this item?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No records found.</p>
            <?php endif; ?>
        </section>

        
    </div>
</body>
</html>