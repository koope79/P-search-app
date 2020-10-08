<?php

$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$ID = json_decode($_POST['ID']);


$sql = 'DELETE FROM allads WHERE ID = :ID';
$query = $pdo -> prepare($sql);

$query -> execute(['ID' => $ID]);

?>