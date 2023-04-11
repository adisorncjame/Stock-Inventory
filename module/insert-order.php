<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $OrderDate = $_POST["OrderDate"];
     $ProductId = $_POST["ProductId"];
     $NumberShipped = $_POST["NumberShipped"];
     $First = $_POST["First"];
     $query = "INSERT INTO orders(First,ProductId,NumberShipped,OrderDate)VALUES('$First','$ProductId','$NumberShipped','$OrderDate')";
     $result=mysqli_query($connect, $query);

     if($result){
          $sql5 = "SELECT * FROM products WHERE id = $ProductId ";
          $results5 = $connect->query($sql5);
          if($results5){
               while($rows5 = $results5->fetch_assoc())
               {
                    $numInventoryShipped =$NumberShipped + $rows5['InventoryShipped'];
                  
               }
               $querypp = "UPDATE products SET InventoryShipped = '$numInventoryShipped' WHERE id= '$ProductId'";
               $resultpp=mysqli_query($connect, $querypp);
               if($resultpp){
                    echo  true;
               }
              
          }
          echo  true;
     } else {
          echo false;
     }
}
?>