<?php

$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'u1175739_default'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $password);


?>