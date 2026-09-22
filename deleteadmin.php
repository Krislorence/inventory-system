<?php
include "database.php";
$id= $_GET['id'];
mysqli_query($conn, "DELETE FROM userss WHERE id=$id");
header("Location:viewregisteruser.php");