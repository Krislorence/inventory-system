<?php
include "db.php";
$id= $_GET['id'];
mysqli_query($conn, "DELETE FROM kongkong_tb WHERE id=$id");
header("Location:view.php");