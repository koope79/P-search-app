<?php

include 'connect.php';

$ID = json_decode($_POST['ID']);


$sql = 'DELETE FROM allads WHERE ID = :ID';
$query = $pdo -> prepare($sql);

$query -> execute(['ID' => $ID]);

?>