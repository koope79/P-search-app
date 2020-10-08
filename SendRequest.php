<?php

$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$query = $pdo -> query('SELECT * FROM users');

if($_POST['name']) {
   
   
    $login = json_decode($_POST['name']);
    $pass = json_decode($_POST['parol']);

    while ($row = $query->fetch(PDO::FETCH_OBJ)) 
    {
        if(($login & $pass) == ($row->login & $row->pass)){
            print('Вход');
        }
    }
    
}

?>