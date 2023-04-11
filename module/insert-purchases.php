<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $SupplierId = $_POST["SupplierId"];
     $ProductId = $_POST["ProductId"];
     $NumberReceived = $_POST["NumberReceived"];
     $PurchaseDate = $_POST["PurchaseDate"];
     $query = "INSERT INTO purchases(SupplierId,ProductId,NumberReceived,PurchaseDate)VALUES('$SupplierId','$ProductId','$NumberReceived','$PurchaseDate')";
     $result=mysqli_query($connect, $query);

     if($result){
          $sql5 = "SELECT * FROM products WHERE id = $ProductId ";
          $results5 = $connect->query($sql5);
          if($results5){
               while($rows5 = $results5->fetch_assoc())
               {
                    $numInventoryReceived =$NumberReceived + $rows5['InventoryReceived'];
                    $numInventoryShipped =$numInventoryReceived - $rows5['InventoryShipped'];
                  
               }
               $querypp = "UPDATE products SET InventoryOnHand = '$numInventoryShipped',InventoryReceived = '$numInventoryReceived' WHERE id= '$ProductId'";
               $resultpp=mysqli_query($connect, $querypp);
               if($resultpp){
                    echo  true;
               }
              
          }
        
        
     } else {
          echo false;
     }
}
?>