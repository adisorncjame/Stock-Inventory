<?php
include('../config/database.php');
$id = $_GET['id'];

$connect = mysqli_connect($servername, $username, $password, $dbname);

if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

if (!empty($id)) {
     $query = "DELETE FROM user WHERE id=$id";
     $result = $connect->query($query);
     if($result){
          echo true;
     } else {
          echo false;
     }
}

?>