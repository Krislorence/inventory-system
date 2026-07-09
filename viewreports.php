<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "kongkong_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$lowStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kongkong_tb WHERE quantity <= 5"))['count'];
$outOfStock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kongkong_tb WHERE quantity = 0"))['count'];
$totalValue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(quantity * price) as total FROM kongkong_tb"))['total'] ?? 0;

$sql = "SELECT id, item_name, category, quantity, price, last_updated, updated_by FROM kongkong_tb";
$result = $conn->query($sql);


$total_value_query = "SELECT SUM(price * quantity) AS total_val FROM kongkong_tb";
$total_result = $conn->query($total_value_query);
$total_row = $total_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="viewreport.css">
</head>
<body>

<div class="report-container">
    <header class="main-header">
    <h1><img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;">System Inventory Report</h1>
</header>
    <div class="ba-box">
        <div class="card">
            <h3>Total Items</h3>
            <p><?php echo $result->num_rows; ?></p>
        </div>
        <div class="card">
            <h3>Total Value</h3>
            <p>₱<?php echo number_format($total_row['total_val'], 2); ?></p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">Print Report</button>
    <a href="index.php" class="btn-back">Back</a>

     <div class="stats-pwet">

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
        
</div>

</body>
</html>

<?php $conn->close(); ?>