<?php
$status = htmlspecialchars($_GET['status']);
$id = htmlspecialchars($_GET['id']);
$bd = mysqli_connect("127.0.0.1", "root", "", "task");
$query = mysqli_query($bd, "UPDATE task SET status = '$status' WHERE id = '$id';");
?>