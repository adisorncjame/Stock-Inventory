<?php
include('../config/database.php');
 if($_GET){
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if ($connect->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = $_GET['id'];

    $sql5 = "SELECT * FROM user WHERE id = $id";

    $results5 = $connect->query($sql5);
   
    $resultArray = array();
	while($rows5 = $results5->fetch_assoc())
	{
		array_push($resultArray,$rows5);
    }
        echo json_encode( $resultArray);
    }
?>