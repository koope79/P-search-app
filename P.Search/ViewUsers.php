<?php

$nUser ='';

include 'connect.php';

$query = $pdo -> query('SELECT * FROM users');

// Перебираем способом ассоциативного массива

while ($row = $query->fetch(PDO::FETCH_OBJ)) {

    echo $row->login."  ";
    echo $row->pass."<br>";

}

?>