<?php
include('../config/database.php');

$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $id = $_POST["id"];
     $ProductId = $_POST["ProductId"];
     $OrderDate = $_POST["OrderDate"];
     $NumberShipped = $_POST["NumberShipped"];
     $Last = $_POST["Last"];
     $query = "UPDATE orders SET ProductId = '$ProductId',OrderDate = '$OrderDate',NumberShipped = '$NumberShipped',Last = '$Last' WHERE id= '$id'";
     $result = $connect->query($query);
     if($result){
          echo true;
     } else {
          echo false;
     }
}
?>