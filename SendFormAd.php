<?php

$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$Visitor = json_decode($_POST['VISITOR']);
$Type = json_decode($_POST['TYPE']);
$Header = json_decode($_POST['HEADER']);
$Address = json_decode($_POST['ADDRESS']);
$Description = json_decode($_POST['DESCRIPTION']);
$Room = json_decode($_POST['ROOM']);
$Square = json_decode($_POST['SQUARE']);
$Price = json_decode($_POST['PRICE']);
$Cur = "₽";

$sql = 'INSERT INTO allads (Owner, Params, Rooms, Square, Header, HouseName, Description, Price, Currency) VALUES (:Visitor, :Type, :Room, :Square, :Header, :Address, :Description, :Price, :Cur)';
$query = $pdo -> prepare($sql);

$query -> execute(['Visitor' => $Visitor, 'Type' => $Type, 'Room' => $Room, 'Square' => $Square, 'Header' => $Header, 'Address' => $Address, 'Description' => $Description, 'Price' => $Price, 'Cur' => $Cur]);


?>