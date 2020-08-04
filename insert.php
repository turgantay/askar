<?php
$name_user = htmlspecialchars($_GET['name_user']);
$email = htmlspecialchars($_GET['email']);
$task_text = htmlspecialchars($_GET['text']);

$bd = mysqli_connect("127.0.0.1", "root", "", "task");
$query = mysqli_query($bd, "INSERT INTO task (name_user, email,task_text) VALUES('$name_user', '$email', '$task_text')");
?>