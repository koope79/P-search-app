<?php


$user = 'root'; // пользователь
$password = 'root'; // пароль
$db = 'user'; // название бд
$host = 'localhost'; // хост
$charset = 'utf8'; // кодировка
// Создаём подключение
$pdo = new PDO("mysql:host=$host;dbname=$db;cahrset=$charset", $user, $password);

$stroka = "";

$Load = json_decode($_POST['LOAD']);
$NameOwner = json_decode($_POST['NAMEOWNER']);

$SelType = json_decode($_POST['SEL_TYPE']);
$SelRoom = json_decode($_POST['SEL_ROOM']);
$PriceFil_1 = json_decode($_POST['PRICE_FIL_1']);
$PriceFil_2 = json_decode($_POST['PRICE_FIL_2']);
$Square_1 = json_decode($_POST['SQUARE_1']);
$Square_2 = json_decode($_POST['SQUARE_2']);

$Street = json_decode($_POST['STREET']);

/*
echo $SelType."<br>";
echo $SelRoom."<br>";
echo $PriceFil_1."<br>";
echo $PriceFil_2."<br>";
echo $Square_1."<br>";
echo $Square_2."<br>";
echo $Street;
*/


if($Load == 'check'){
  if ($NameOwner != 'All') $Own = "WHERE Owner = '".$NameOwner."'";
  else $Own = "WHERE 1";
function st($st,$sr,$P_1,$P_2,$S_1,$S_2,$ASS){
  
  if($sr < 4){$vv = "(Rooms = '$sr')";}
  else{$vv = "(Rooms >= '4')";}

  if($st && $sr && $P_1 && $P_2 && $S_1 && $S_2 && $ASS){ // +
    //echo "alo";
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND (Square BETWEEN $S_1 AND $S_2) AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $P_2 && $S_1 && $S_2){  // +
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND (Square BETWEEN $S_1 AND $S_2))";
    return $Own." AND ".$strr;   
  }
  else if($st && $sr && $P_1 && $P_2 && $S_1 && $ASS){  //  +
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND Square > $S_1 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;  
  }
  else if($st && $sr && $P_1 && $P_2 && $S_2 && $ASS){  //  +
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND Square < $S_2 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $P_2 && $S_1){
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $P_2 && $S_2){
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $P_2 && $ASS){  //  +
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2) AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_1 && $S_2 && $ASS){  // +
    $strr = " (Params = '$st' AND $vv AND (Square BETWEEN $S_1 AND $S_2) AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;    
  }
  else if($st && $sr && $P_1 && $ASS){  // +
    $strr = " (Params = '$st' AND $vv AND (Price > $P_1) AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_2 && $ASS){  // +
    $strr = " (Params = '$st' AND $vv AND (Price < $P_2) AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }  
  else if($st && $sr && $P_1 && $P_2){
    $strr = " (Params = '$st' AND $vv AND (Price BETWEEN $P_1 AND $PF_2))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $S_1){
    $strr = " (Params = '$st' AND $vv AND Price > $P_1 AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1 && $S_2){
    $strr = " (Params = '$st' AND $vv AND Price > $P_1 AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_1 && $ASS){  // +
    $strr = " (Params = '$st' AND $vv AND Square > $S_1 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_2 && $ASS){  // +
    $strr = " (Params = '$st' AND $vv AND Square < $S_2 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_1 && $S_2){
    $strr = " (Params = '$st' AND $vv AND (Square BETWEEN $S_1 AND $S_2))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $ASS){
    $strr = " (Params = '$st' AND $vv AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_1){
    $strr = " (Params = '$st' AND $vv AND Price > $P_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $P_2){
    $strr = " (Params = '$st' AND $vv AND Price < $P_2)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_1){
    $strr = " (Params = '$st' AND $vv AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $sr && $S_2){
    $strr = " (Params = '$st' AND $vv AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($st && $ASS){ // +
    $strr = " (Params = '$st' AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }
  else if($st && $sr){
    $strr = " (Params = '$st' AND $vv)";
    return $Own." AND ".$strr;
  }
  else if($st && $P_1){
    $strr = " (Params = '$st' AND Price > $P_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $P_2){
    $strr = " (Params = '$st' AND Price < $P_2)";
    return $Own." AND ".$strr;
  }
  else if($st && $S_1){
    $strr = " (Params = '$st' AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($st && $S_2){
    $strr = " (Params = '$st' AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($sr && $ASS){ //  +
    $strr = " ($vv AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }    
  else if($sr && $P_1){
    $strr = " ($vv AND Price > $P_1)";
    return $Own." AND ".$strr;
  } 
  else if($sr && $P_2){
    $strr = " ($vv AND Price < $P_2)";
    return $Own." AND ".$strr;
  }
  else if($sr && $S_1){
    $strr = " ($vv AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($sr && $S_2){
    $strr = " ($vv AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($P_1 && $ASS){  //  +
    $strr = " (Price > $P_1 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  } 
  else if($P_1 && $P_2){
    $strr = " (Price BETWEEN $P_1 AND $PF_2)";
    return $Own." AND ".$strr;
  }
  else if($P_1 && $S_1){
    $strr = " (Price > $P_1 AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($P_1 && $S_2){
    $strr = " (Price > $P_1 AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($P_2 && $ASS){  //  +
    $strr = " (Price < $P_2 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;
  }  
  else if($P_2 && $S_1){
    $strr = " (Price < $P_2 AND Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($P_2 && $S_2){
    $strr = " (Price < $P_2 AND Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($S_1 && $ASS){  //  +
    $strr = " (Square > $S_1 AND (HouseName LIKE '$ASS%'))";
    return $Own." AND ".$strr;  
  }
  else if($S_1 && $S_2){
    $strr = " (Square BETWEEN $S_1 AND $S_2)";
    return $Own." AND ".$strr;
  }
  else if($st){
    $strr = " (Params = '$st')";
    return $Own." AND ".$strr;
  }
  else if($sr){
    $strr = " $vv";
    return $Own." AND ".$strr;
  }
  else if($P_1){
    $strr = " (Price > $P_1)";
    return $Own." AND ".$strr;
  }
  else if($P_2){
    $strr = " (Price < $P_2)";
    return $Own." AND ".$strr;
  }
  else if($S_1){
    $strr = " (Square > $S_1)";
    return $Own." AND ".$strr;
  }
  else if($S_2){
    $strr = " (Square < $S_2)";
    return $Own." AND ".$strr;
  }
  else if($ASS){
    $strr = " (HouseName LIKE '$ASS%')";
    return $Own." AND ".$strr;    
  }
  else {
    $strr = "";
    return $strr;
  } 
}
$gg = st($SelType,$SelRoom,$PriceFil_1,$PriceFil_2,$Square_1,$Square_2,$Street);

$sql = "SELECT `ID`, `Owner`, `Params`, `Rooms`, `Square`, `Header`, `HouseName`, `Description`, `Price`, `Currency` FROM `allads` $Own ".$gg;

//echo $sql;

$query = $pdo -> query($sql);

$i=0;

  while ($row = $query->fetch(PDO::FETCH_OBJ)) {

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


if($Load == 'load'){


    echo "<div id=Filters>


    
    <div class=sc_fil>
      <span class=span_fil>Тип:</span>
      <div id=Sel style='box-sizing: border-box;'>
        <select id=select class=inputSel>
          <option value='' selected>---</option>
          <option value=Продажа>Продажа</option>
          <option value=Аренда>Аренда</option>
        </select>
      </div>
    </div>


    <div class=sc_fil>
      <span class=span_fil>Комнат:</span>
      <div id=Room_fil style='box-sizing: border-box;'>
        <select id=select_room class=inputSel>
          <option value='' selected>---</option>
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4+</option>
        </select>
      </div>
    </div>


    <div class=sc_fil>
      <span class=span_fil>Цена,&#8381;:</span>
      <div>
        <input type=text id=Input_fil_1 size=8 placeholder=от>&nbsp;<input type=text id=Input_fil_2 size=8 placeholder=до>
      </div>
    </div>


    <div class=sc_fil>
      <span class=span_fil>Площадь,&nbsp;м²:</span>
      <div>
        <input type=text id=Input_fil_3 size=8 placeholder=от>&nbsp;<input type=text id=Input_fil_4 size=8 placeholder=до>
      </div>
    </div>

    <div class=sc_fil>
      <span class=span_fil>Улица:</span>
      <div>
      <input type=text id=Input_fil_Adr onchange=getAddress(this.value); size=20 placeholder=Адрес>
      </div>
    </div>

  </div>";
}

?>