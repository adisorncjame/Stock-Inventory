<?php
include('../config/database.php');
$id = $_GET['id'];
$supplier = $_GET['supplier'];

$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($id)) {
     $query = "UPDATE suppliers SET supplier = '$supplier' WHERE id= '$id'";
     $result = $connect->query($query);
     if($result){
          echo true;
     } else {
          echo false;
     }
}
?>