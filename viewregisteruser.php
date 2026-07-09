<?php
include "database.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $search ? "WHERE username LIKE '%$search%' OR pssword LIKE '%$search%' OR fullname LIKE '%$search%'" : "";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="viewregisteruser.css">
    </head>
    <body>
        
        <div class="main-container">
            <header class="main-header">
            <h1><img src="logo.png" alt="Logo" style="width: 100px;  vertical-align: middle; margin-left: 0;">Users Registered in our System</h1>
            <div class="header-tools">
                <form method="GET" class="search-box">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search username">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <a href="view.php" class="btn-add">View Item</a>
            </div>
            </header>
         <section class="content-section">
        <table class="my-table">
            <thead>
            <tr>
                <th class="frm-id">Id</th>
                <th class="frm-id">Username</th>
                <th class="frm-id">Password</th>
                <th class="frm-id">Action</th>
                
            </tr>
            </thead>

            
           
            <tbody>
    <?php
        include "database.php"; 
        $sql = "SELECT * FROM users_tb $whereClause";
        $result = mysqli_query($conn, $sql);
        
        while($row = mysqli_fetch_assoc($result)){
    ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['username']; ?></td>
            <td><?= $row['pssword']; ?></td>
            <td class="actions">
                                    <a href="deleteadmin.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Delete this item?')">Delete</a>
                                </td>
        </tr>
    <?php } ?>
</tbody>
            
        </table>
    </section>
    </body>
    </div>
</html>