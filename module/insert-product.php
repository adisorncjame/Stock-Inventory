<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $ProductName = $_POST["ProductName"];
     $PartNumber = $_POST["PartNumber"];
     $ProductLabel = $_POST["ProductLabel"];
     $StartingInventory = $_POST["StartingInventory"];
     $InventoryReceived = $_POST["InventoryReceived"];
     $InventoryShipped = $_POST["InventoryShipped"];
     $InventoryOnHand = $_POST["InventoryOnHand"];
     $MinimumRequired = $_POST["MinimumRequired"];
     $query = "INSERT INTO products(ProductName,PartNumber,ProductLabel,StartingInventory,InventoryReceived,InventoryShipped,InventoryOnHand,MinimumRequired)VALUES('$ProductName','$PartNumber','$ProductLabel','$StartingInventory','$InventoryReceived','$InventoryShipped','$InventoryOnHand','$MinimumRequired')";
     $result=mysqli_query($connect, $query);

     if($result){
          echo  true;
     } else {
          echo false;
     }
}
?>