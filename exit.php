<?php
//Стартуем сессию
session_start();
//Уничтожаем сессию
session_destroy();
//И сразу перенаправляем на нужную страницу пользователя
header('Location: auth.php');
exit;
?>