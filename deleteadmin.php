<?php
include "database.php";
$id= $_GET['id'];
mysqli_query($conn, "DELETE FROM users_tb WHERE id=$id");
header("Location:viewregisteruser.php");