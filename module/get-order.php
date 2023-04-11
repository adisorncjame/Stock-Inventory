<?php
include('../config/database.php');
 if($_GET){
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if ($connect->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = $_GET['id'];

    $sql5 = "SELECT id,Title,Middle,ProductId,NumberShipped,OrderDate FROM orders WHERE id = $id ";

    $results5 = $connect->query($sql5);
   
    $resultArray = array();
	while($rows5 = $results5->fetch_assoc())
	{
		array_push($resultArray,$rows5);
	
     // while($row3 = $result3->fetch_assoc())
     // {
     // // $data["PurchaseDate"] =$row3["PurchaseDate"];
     // // $data["NumberReceived"] =$row3["NumberReceived"];
     // // $data["supplier"] =$row3["supplier"];
     // // $data["ProductName"]=$row3["ProductName"]." - ". $row3["PartNumber"];
     echo json_encode( $resultArray);
    }
}
?>