<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
     $id =$_GET['id'];
     $sql2 = "SELECT purchases.PurchaseDate,purchases.NumberReceived,suppliers.supplier,products.ProductName,products.PartNumber FROM purchases INNER JOIN suppliers ON suppliers.id =purchases.SupplierId INNER JOIN products
     ON products.id = purchases.ProductId WHERE purchases.ProductId =$id";
     $result3 = $connect->query( $sql2);
     $resultArray = array();
	while($row3 = $result3->fetch_assoc())
	{
		array_push($resultArray,$row3);
	}
     // while($row3 = $result3->fetch_assoc())
     // {
     // // $data["PurchaseDate"] =$row3["PurchaseDate"];
     // // $data["NumberReceived"] =$row3["NumberReceived"];
     // // $data["supplier"] =$row3["supplier"];
     // // $data["ProductName"]=$row3["ProductName"]." - ". $row3["PartNumber"];
     echo json_encode( $resultArray);
     // }

     

?>