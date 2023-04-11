<?php
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
     $name = $_POST["name"];
     $username = $_POST["username"];
     $password = $_POST["password"];
     $IsActive = $_POST["IsActive"];
     $email = $_POST["email"];
     $level = $_POST["level"];
     $CreateDate = date("Y-m-d H:i:s");;


     $query = "INSERT INTO user(id,name,username,password,IsActive,email,level,CreateDate,UpdateDate)VALUES('','$name','$username','$password','$IsActive','$email','$level','$CreateDate','$CreateDate')";
     $result=mysqli_query($connect, $query);

     if($result){
          echo  true;
     } else {
          echo false;
     }
}
?>