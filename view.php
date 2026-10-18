<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}
include "db.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $search ? "WHERE item_name LIKE '%$search%' OR category LIKE '%$search%' OR updated_by LIKE '%$search%'" : "";

$countResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM kriskong_tb $whereClause");
$totalRecords = mysqli_fetch_assoc($countResult)['total'];

$sql = "SELECT * FROM kriskong_tb $whereClause ORDER BY last_updated DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Records</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="view.css">
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div>

                <a href="additem.php" class="btn-new-item">
                    <i class="fa-solid fa-plus"></i> New Item
                </a>

                <ul class="nav-menu">
                    <li>
                        <a href="index.php" class="nav-link">
                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="view.php" class="nav-link active">
                            <i class="fa-solid fa-box-archive"></i>
                            Inventory Records
                        </a>
                    </li>
                    <li>
                        <a href="viewreports.php" class="nav-link">
                            <i class="fa-solid fa-chart-line"></i>
                            Reports
                        </a>
                    </li>
                    
                    <li>
                        <a href="about.php" class="nav-link">
                            <i class="fa-solid fa-circle-info"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="nav-link">
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
                    <h1>Inventory Records</h1>
                    <p style="color: black;">Manage and View all registered items (Total: <?= $totalRecords ?>)</p>
                </div>

                <form method="GET" action="view.php" class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color: white;"></i>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search records...">
                </form>
            </header>
            <section class="records-card">
                <div class="card-header-flex">
                    <h3>Product List</h3>
                    <a href="additem.php" class="btn-add-table"><i class="fa-solid fa-plus"></i> Add Item</a>
                </div>

                <?php if($totalRecords > 0): ?>
                    <div class="table-responsive">
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
                                        <td><strong><?= htmlspecialchars($row['item_name']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['category']) ?></td>
                                        <td>
                                            <?php if($row['quantity'] == 0): ?>
                                                <span class="badge danger">Out of Stock (0)</span>
                                            <?php elseif($row['quantity'] <= 5): ?>
                                                <span class="badge warning">Low Stock (<?= $row['quantity'] ?>)</span>
                                            <?php else: ?>
                                                <span class="badge success"><?= $row['quantity'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>₱<?= number_format($row['price'], 2) ?></td>
                                        <td><?= date('M j, Y', strtotime($row['last_updated'])) ?></td>
                                        <td><?= htmlspecialchars($row['updated_by']) ?></td>
                                        <td class="actions">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-action edit-link" title="Edit Item">
                                                 Edit
                                            </a>
                                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn-action delete-link" onclick="return confirm('Sigurado ka bang gusto mong burahin ang item na ito?')" title="Delete Item">
                                                 Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data-box">
                        <i class="fa-solid fa-folder-open"></i>
                        <p>No inventory records found.</p>
                    </div>
                <?php endif; ?>
            </section>

            <footer class="app-footer">
                <p>&copy; 2026 CCDI LEGAZPI BSIT-3E Midterm | Designed by Kris Lorence L. Chan, Cj Maquiñana, Efren Añunuevo, John Matthew Recuenco </p>
                </footer>

        </main>
    </div>

</body>
</html>