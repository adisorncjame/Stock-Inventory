<?php
include('../config/database.php');

$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {

     $id = $_POST["id"];
     $name = $_POST["name"];
     $username = $_POST["username"];
     $password = $_POST["password"];
     $IsActive = $_POST["IsActive"];
     $email = $_POST["email"];
     $level = $_POST["level"];
     $UpdateDate = date("Y-m-d H:i:s");;

     $query = "UPDATE user SET name = '$name',username = '$username',password = '$password',IsActive = '$IsActive',email = '$email',level = '$level' ,UpdateDate = '$UpdateDate' WHERE id= '$id'";
     $result = $connect->query($query);
     if($result){
          echo true;
     } else {
          echo false;
     }
}

?>