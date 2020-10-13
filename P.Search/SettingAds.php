<?php

include 'connect.php';

$sql = "SELECT * FROM allads";
$query = $pdo -> query($sql);

$Line = json_decode($_POST['Settings']);
$IdUsera = json_decode($_POST['ID']);
#echo $IdUsera;



if($Line == "List"){
    
    if($IdUsera){
        while ($row = $query->fetch(PDO::FETCH_OBJ)) 
        {   
            if($IdUsera == ($row->ID)){
                $NameUSER = $row->Owner;
                $TYPE = $row->Params;
                $HEADER = $row->Header;
                $ADDRESS = $row->HouseName;
                $DESC = $row->Description;
                $PRICE = $row->Price;
                $SQUARE = $row->Square;
                break;
            }
        } 
    }

    echo "<tr>";
    echo "</tr>";

    echo "<h1></h1><br>
        <div id=NewAd>
        
        <div class=sc>
            <label class=sc-lab>Тип:</label>
        </div>
        
        <select id=SelectArea class=inputSel onchange=(function(){SelectArea.style.borderColor='rgba(12,240,31,0.404)';})();>
            <option value='' disabled selected>---</option>
            <option value=Продажа>Продажа</option>
            <option value=Аренда>Аренда</option>
        </select><br><br>

        <div class=sc>
            <label class=sc-lab>Заголовок:</label>
        </div>
        <div class=stroka>
            <input value='".$HEADER."' id=HeaderArea type=text class=InputLine size=70 onchange=(function(){HeaderArea.style.borderColor='rgba(12,240,31,0.404)';})();>
        </div><br><br>

        <div class=sc>
            <label class=sc-lab>Адрес:</label>
        </div>
        <div class=stroka>
            <input value='".$ADDRESS."' id=HouseArea type=text class=InputLine size=70 onblur=getAddress(this.value);>
        </div><br><br>

        <div class=sc>
            <label class=sc-lab>Описание:</label>
        </div>
        <div class=stroka>
            <textarea id=DesciptArea style='resize: none;' rows=5 cols=53 maxlength=200 onchange=(function(){DesciptArea.style.borderColor='rgba(12,240,31,0.404)';})();>".$DESC."</textarea>
        </div><br>

        <div>
            <div class=sc>
                <label class=sc-lab>Комнат:</label>
            </div>
            <select id=RoomArea class=inputSel onchange=(function(){RoomArea.style.borderColor='rgba(12,240,31,0.404)';})();>
                <option value='' disabled selected>---</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4+</option>
            </select>

            <div class=sc style=width:359px;float:right;>
                <label class=sc-lab>Общая площадь:</label>
                <input value='".$SQUARE."' id=SquareArea type=text class=InputLine size=20 onchange=(function(){SquareArea.style.borderColor='rgba(12,240,31,0.404)';})();>&nbsp;м²
            </div>

        </div>

        <br><br>

        <div class=sc>
            <label class=sc-lab>Цена:</label>
        </div>
        <div class=stroka>
            <input value='".$PRICE."' id=PriceArea type=text class=InputLine size=15 onchange=(function(){PriceArea.style.borderColor='rgba(12,240,31,0.404)';})();>&nbsp;&#8381;
        </div><br><br>

        <div id=ErrorForm></div><br>

    </div>";

    

    if($IdUsera){
        echo "<a href=javascript:UpdateForm(".$IdUsera."); class='sendButton'>Обновить</a>";
        echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';Ads.style.display='block';})();></a>";
    } 
    else{
        echo "<a href=javascript:CreateFormAd(); class='sendButton'>Создать</a>";
        echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';})();></a>";
    } 
    

}


else if($IdUsera == "Delete"){

    echo "<h1>Удалить Объявление</h1><br>";
    //echo "<b style='font-size:30px'>Редактировать</b>"."<br><br>";
    echo "<table id=list width=600px cellpadding=10>";

    while ($row = $query->fetch(PDO::FETCH_OBJ)) {

        if($Line == ($row->Owner)){
            
            echo "<tr>";

            echo "<td id=".$row->ID." onclick=DeleteAd(".$row->ID.");addPost(".$_POST['Settings'].");AllmapMarkers();(function(){document.body.style.overflow='auto';document.location='#';})();>";
            
            #echo "<td id=".$row->ID." onclick=LinkAd(".$row->ID.");>";
            echo "<b style='font-size:18px'>".$row->Header."</b>"."<br>";
            echo $row->HouseName."<br>";
            echo $row->Description."<br><br>";
            echo $row->Price."  ";
            echo $row->Currency;
            echo "</a>";
            echo "</td>";
            echo "</tr>";
            
        }

    }

    echo "</table><br>";
    echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';Ads.style.display='block';})();></a>";
}


else if($Line){

    echo "<h1>Редактировать</h1><br>";

    echo "<table id=list width=600px cellpadding=10>";

    while ($row = $query->fetch(PDO::FETCH_OBJ)) {

        if($Line == ($row->Owner)){
            
            echo "<tr>";

            echo "<td id=".$row->ID." onclick=EditForm(".$row->ID.");SetAtr('".$row->Params."',".$row->Rooms.");>";
            
            echo "<b style='font-size:18px'>".$row->Header."</b>"."<br>";
            echo $row->HouseName."<br>";
            echo $row->Description."<br><br>";
            echo $row->Price."  ";
            echo $row->Currency;
            echo "</a>";
            echo "</td>";
            echo "</tr>";
            
        }

    }

    echo "</table><br>";
    echo "<a href='#' class='close' onclick=(function(){document.body.style.overflow='auto';Ads.style.display='block';})();></a>";
    
}


?>

