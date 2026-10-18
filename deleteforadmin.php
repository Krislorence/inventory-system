<?php
include "db.php";
$id= $_GET['id'];
mysqli_query($conn, "DELETE FROM kriskong_tb WHERE id=$id");
header("Location:inventoryforadmin.php");