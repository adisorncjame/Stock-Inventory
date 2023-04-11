<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $username = $_POST["username"];
     $password = $_POST["password"];
     $email = $_POST["email"];
     $CreateDate = date("Y-m-d H:i:s");

     $query = "INSERT INTO user(username,password,email,CreateDate)VALUES('$username','$password','$email','$CreateDate')";
     $result=mysqli_query($connect, $query);

     if($result){
          echo true;
     } else {
          echo false;
     }
}
?>