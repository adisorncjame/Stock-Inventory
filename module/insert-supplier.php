<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $name = mysqli_real_escape_string($connect, $_POST["name"]);
     $query = "INSERT INTO suppliers(supplier)VALUES('$name')";
     mysqli_query($connect, $query);
}
?>