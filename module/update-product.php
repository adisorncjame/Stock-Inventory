<?php
include('../config/database.php');

$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $id = $_POST["id"];
     $ProductName = $_POST["ProductName"];
     $PartNumber = $_POST["PartNumber"];
     $ProductLabel = $_POST["ProductLabel"];
     $StartingInventory = $_POST["StartingInventory"];
     $InventoryReceived = $_POST["InventoryReceived"];
     $InventoryShipped = $_POST["InventoryShipped"];
     $InventoryOnHand = $_POST["InventoryOnHand"];
     $MinimumRequired = $_POST["MinimumRequired"];
     $query = "UPDATE products SET ProductName = '$ProductName',PartNumber = '$PartNumber',ProductLabel = '$ProductLabel',StartingInventory = '$StartingInventory',InventoryReceived = '$InventoryReceived',InventoryShipped = '$InventoryShipped',InventoryOnHand = '$InventoryOnHand',MinimumRequired = '$MinimumRequired' WHERE id= '$id'";
     $result = $connect->query($query);
     if($result){
          echo true;
     } else {
          echo false;
     }
}
?>