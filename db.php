<?php
$conn= mysqli_connect("localhost:3307", "root", "", "kongkong_db");
if(!$conn) {
    die("Connection Failed: " . mysqli_connection_error());
}
?>