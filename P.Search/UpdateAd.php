<?php

include 'connect.php';

$ID = json_decode($_POST['ID']);
$Visitor = json_decode($_POST['VISITOR']);
$Type = json_decode($_POST['TYPE']);
$Header = json_decode($_POST['HEADER']);
$Address = json_decode($_POST['ADDRESS']);
$Description = json_decode($_POST['DESCRIPTION']);
$Room = json_decode($_POST['ROOM']);
$Square = json_decode($_POST['SQUARE']);
$Price = json_decode($_POST['PRICE']);


$sql = 'UPDATE allads SET Owner = :Visitor, Params = :Type, Rooms = :Room, Square = :Square, Header = :Header, HouseName = :Address, Description = :Description, Price = :Price   WHERE ID = :ID ';
$query = $pdo -> prepare($sql);

$query -> execute(['Visitor' => $Visitor,'Type' => $Type,'Room' => $Room, 'Square' => $Square, 'Header' => $Header, 'Address' => $Address, 'Description' => $Description, 'Price' => $Price, 'ID' => $ID]);

?>