<?php

$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$create = json_decode($_POST['CREATE_FORM']);
$send = json_decode($_POST['SEND']);

$nameR = json_decode($_POST['NAMEREG']);
$passR = json_decode($_POST['PASSREG']);
$telR = json_decode($_POST['TELREG']);


$query = $pdo -> query('SELECT * FROM users');

if($send){
    #print('reg-ok');

    while ($row = $query->fetch(PDO::FETCH_OBJ)) 
    {
        if(($nameR == $row->login) || ($telR == $row->tel)){
            print('zanyato');
            break;
        }
    }

    if(!$row){
        $sqlR = 'INSERT INTO users (login, pass, tel) VALUES (:nameR, :passR, :telR)';
        $send_query = $pdo -> prepare($sqlR);
        $send_query -> execute(['nameR' => $nameR, 'passR' => $passR, 'telR' => $telR]);
    }


}

elseif($create){
    echo "
        <div id=Form_REG style=position:relative;top:8%;>
            <label>
                <p>Логин<br><input  id=nameReg class=SearchLine style=height:25px; type=text name=name size=25 required/></p>
            </label>

            <label>
                <p>Пароль<br><input id=passReg class=SearchLine style=height:25px; type=password name=pass size=25 required/></p>
            </label>

            <label>
                <p>Телефон<br><input id=telReg class=SearchLine style=height:25px; type=text name=tel size=25 required/></p>
            </label><br>

            <button id=send_reg_button class=ost_buttons onclick=Send_reg_form(); style=width:155px;color:#000000;background-color:#b6c8ff96;>Зарегистрироваться</button>
        </div>
    ";

    echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';})();></a>";
}




?>