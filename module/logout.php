<?php
session_start();
unset($_SESSION["level"]);
unset($_SESSION["username"]);
header("Location:../login.php");
?>