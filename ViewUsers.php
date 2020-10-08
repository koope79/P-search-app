<?php

$nUser ='';
$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$query = $pdo -> query('SELECT * FROM users');

// Перебираем способом ассоциативного массива

while ($row = $query->fetch(PDO::FETCH_OBJ)) {

    echo $row->login."  ";
    echo $row->pass."<br>";

}

?>