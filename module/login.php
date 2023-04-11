<?php
session_start();
include('../config/database.php');
$connect = mysqli_connect($servername, $username, $password, $dbname);
if ($connect->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];

     $sql5 = "SELECT * FROM user WHERE username = '".$username."' AND password = '".$password."' AND IsActive = 1";
     $results5 = $connect->query($sql5);
     while($row = $results5->fetch_assoc()){
        $_SESSION["username"] = $row['username'];
        $_SESSION["level"] = $row['level'];
        $_SESSION["name"] = $row['name'];
     }
    if($_SESSION["username"] == ""){
        echo false;
    }else{
        echo true;
    }
   
    //  if(!$rows5){
    //      echo false;
    //  }else{
    //      echo true;
    //  }
     
}
?>