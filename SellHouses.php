<?php


$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$NameUSER = $_POST['nameNS'];
$sql = "SELECT * FROM allads";

$query = $pdo -> query($sql);

$i=0;
if($_POST['nameNS']){


    while ($row = $query->fetch(PDO::FETCH_OBJ)) {

        if(substr($NameUSER,1,-1) == ($row->Owner))
        {
            echo "<tr>";

            echo "<td class=FirstTd id=".$row->ID." onclick=LinkAd(".$row->ID.");>";
            echo "<b style='font-size:18px;'>".$row->Header."</b>"."<br>";
            echo "<div style='margin-top:6px;'>".$row->HouseName."</div>";
            echo "<div style='margin-top:6px;'>".$row->Description."</div>";
            echo "<div style='margin-top:12px;'><span style='margin-right:auto;font-size:18px;line-height: 20px;'>".$row->Price."  ".$row->Currency."</span></div>";
            echo "</a>";
            echo "</td>";
            echo "</tr>";   

        }


        else if(substr($NameUSER,1,-1) == "All"){

            if($i%2 == 0)echo "<tr>";
            
            echo "<td class=FirstTd width=250px id=".$row->ID." onclick=LinkAd(".$row->ID.");>";
            echo "<b style='font-size:18px;'>".$row->Header."</b>"."<br>";
            echo "<div style='margin-top:6px;'>".$row->HouseName."</div>";
            #echo $row->Description."<br>";
            echo "<div style='margin-top:12px;'><span style='margin-right:auto;font-size:18px;line-height: 20px;'>".$row->Price."  ".$row->Currency."</span></div>";
            echo "</a>";
            echo "</td>";
            
            if($i%2 !=0) echo "</tr>";      
            $i=$i+1;
        }

        
    }

}

if($_POST['ID']){

    $AID = json_decode($_POST['ID']);
    
    while ($row = $query->fetch(PDO::FETCH_OBJ)) 
    {   
        if($AID == ($row->ID)){
            echo $row->HouseName;
        }
    }
}

if($_POST['Address']){

    $SearchAdr = json_decode($_POST['Address']);

    while ($row = $query->fetch(PDO::FETCH_OBJ)) 
    {   
        if($SearchAdr == ($row->HouseName)){
            echo "<em style='font-size:12px'>".$row->Params."</em>"."<br>";
            echo "<b style='font-size:16px'>".$row->Header."</b>"."<br>";
            echo "<label style='font-size:14px;display:inline-block;margin:5px;'>".$row->Price."  ".$row->Currency."</label><br>";
            echo "<a href=javascript:ShowFormAd(".$row->ID.");SetAtr('".$row->Params."'); style='margin:5px;'>Показать объявление</a><br><br>";
        }
    }
    

}


?>