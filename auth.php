<?php
session_start();
$login='admin';
$password='123';
if($login==htmlspecialchars($_POST['login']) && $password==htmlspecialchars($_POST['password'])){
$_SESSION['admin'] = "admin";
header("Location:index.php");
 }
 else{
 	include 'error_auth.html';
 }
?>