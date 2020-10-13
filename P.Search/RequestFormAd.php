<?php


include 'connect.php';

$IdAd = json_decode($_POST['ID']);
$Tel_id = json_decode($_POST['OWNER']);

$sql = "SELECT * FROM allads";
$query = $pdo -> query($sql);

$sql_users = "SELECT * FROM users";
$query_users = $pdo -> query($sql_users);

if($Tel_id){

        while ($rowR = $query_users->fetch(PDO::FETCH_OBJ)) 
        {   
            if($Tel_id == ($rowR->login)){
                $Telephon = $rowR->tel;
                break;
            }
        } 

    echo "
            <div style=top:40%;position:relative;>
                <span class=Price style=font-size:19pt;>".$Telephon."</span>
            </div>

        <a href='#zatemnenie' class='close' onclick=(function(){okno_tel.remove();})();></a>";

}

else if($_POST['ID']){

    if($IdAd){
        while ($row = $query->fetch(PDO::FETCH_OBJ)) 
        {   
            if($IdAd == ($row->ID)){
                $NameUSER = $row->Owner;
                $TYPE = $row->Params;
                $HEADER = $row->Header;
                $ADDRESS = $row->HouseName;
                $ROOMS = $row->Rooms;
                $SQUARE = $row->Square;
                $DESC = $row->Description;
                $PRICE = $row->Price;
                break;
            }
        } 
    }

    echo "<tr>";
    echo "</tr>";
    
    echo"
        <div id=NewAd style='margin-left: 25px;'>

            <div style='margin-top: 30px;'>
                <b style='font-size:20px'>".$row->Header."</b><br>
            </div>
            
            <div>
                <em><label style='font-size:14px;display:inline-block;margin-top:8px;'>".$ADDRESS."</label></em>
            </div>

            <div><em>
                <label style='font-size:15px;display:inline-block;margin-top:8px;'>Комант: ".$ROOMS."</label>
                <label style='font-size:15px;display:inline-block;margin-top:8px;margin-left:15px;'>Общая площадь: ".$SQUARE." кв.м</label>
                </em>
            </div>

            <div>
                <label style='font-size:16px;display:inline-block;margin-top:8px;line-height: 20px;'>".$DESC."</label>
            </div>

            <div class=Price_Tel>
                <div style=display:inline-block;width:45%;>
                    <button onclick=ShowTelephon('".$row->Owner."'); class='ost_buttons' style=width:150px;height:29px;>Показать телефон</button>
                </div>
                <div style=display:inline-block;width:50%;text-align:right;>
                    <label style='font-size:18px;display:inline-block;'>".$PRICE."&nbsp;&#8381;</label>
                <div>
                
                
            </div>

        </div>";
    
    echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';})();></a>";
    

}
#<span class=Price>".$PRICE."&nbsp;&#8381;</span>

?>