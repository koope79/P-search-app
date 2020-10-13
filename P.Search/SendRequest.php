<?php

include 'connect.php';

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