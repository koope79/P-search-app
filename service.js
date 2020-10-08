
var ans;
var point;
var Blue_point;
var Searchpoint;
var Visitor;
var list;
var checkgetAddress;
var Vladivostok;
var Adr;
var form_fil;

//  ПОИСК ОБЪЕКТОВ
function getAddress(CoordsName,check) {
        
    //var Och = query.reverse();
    //var revQuery = CoordsName.reverse();
    // 'https://search-maps.yandex.ru/v1/?apikey=f32a162c-34fe-483a-9c1b-6b7ccd31abc6&text=' + query + '&lang=ru_RU&results=1'
    // 'https://geocode-maps.yandex.ru/1.x/?apikey=69637c66-5709-4966-be79-3ca9faadd730&geocode=' + query + '&lang=ru_RU&results=1'

    if(check != 0) Vladivostok = "Владивосток, ";
    else Vladivostok="";
    
    var query = CoordsName;
    $.get('https://search-maps.yandex.ru/v1/?apikey=f32a162c-34fe-483a-9c1b-6b7ccd31abc6&text='+ Vladivostok + query + '&lang=ru_RU&results=1', function(response){
        console.log(response);
         
        if(response.features.length == 0) {
            
            if(document.getElementById('HouseArea')){HouseArea.style.borderColor = "rgba(240, 31, 31, 0.404)"; checkgetAddress = 0;}
            console.log('Введите правильный адрес'); return false;
        }

        for(i in response.features){
            var feature = response.features[i];
            var coords = feature.geometry.coordinates;
            if (typeof(feature.properties.GeocoderMetaData) == "undefined" || (feature.properties.GeocoderMetaData.kind != 'house')) {
                if(document.getElementById('HouseArea')){HouseArea.style.borderColor = "rgba(240, 31, 31, 0.404)"; checkgetAddress = 0;}
                console.log('Введите правильный адрес');
                Adr = feature.properties.name;
                return false;
            }
            
            if(check == 0) Blue_point = new ymaps.Placemark(coords.reverse(),{balloonContentBody: SearchAd(feature.properties.name),hintContent: feature.properties.name});
            else if(check == 2){
                 point= new ymaps.Placemark(coords.reverse(), {balloonContentBody: SearchAd(feature.properties.name),hintContent: feature.properties.name}, {
                    preset: 'islands#redDotIconWithCaption',
                });                
            }
            else {
                myMap.geoObjects.remove(Searchpoint);
                Searchpoint= new ymaps.Placemark(coords.reverse(), {balloonContentBody: SearchAd(feature.properties.name),hintContent: feature.properties.name}, {
                    preset: 'islands#violetDotIconWithCaption',
                });
            }
            //console.log(feature.properties.GeocoderMetaData.kind);

            if(feature.properties.GeocoderMetaData.kind == 'house'){

                //console.log(response);
                window.myMap.geoObjects.add(point);
                if(check == 0)window.myMap.geoObjects.add(Blue_point);
                if(document.getElementById('HouseArea')){HouseArea.style.borderColor = "rgba(12, 240, 31, 0.404)"; checkgetAddress = 1;}
            
                if(check == 1){
                    window.myMap.geoObjects.add(Searchpoint);
                    window.myMap.setCenter(coords, 14);
                }

                if(typeof(check) == "undefined") Adr = feature.properties.name;
                
            }
                
            
        }

    });
}


function checkUsers(){
    const promise = $.ajax(
        {
            type:'GET',
            url: "ViewUsers.php",
            success: function(data){console.log(data);} 
        });
    return promise;
}

//  ВХОД
function SendMessage(nm,ps) {
    const promise = $.ajax(
        {
            type:'POST',
            url:"SendRequest.php",
            async: false,
            data:'name='+JSON.stringify(nm) + '&' + 'parol=' + JSON.stringify(ps),
            dataType: "text",
            success:function(html) {
                console.log(html);
            },
            error: function(dat){
                alert('error');
            }
        
        });

        return promise;
}

//  ДОБАВЛЕНИЕ ОБЪЯВЛЕНИЙ  
function addPost(nameSession) {
    
    ans = SearchHouse(nameSession);
    const ins = document.getElementById('Table');
    Ads.style.display = "block";

    ins.innerHTML = ans.responseText;
    myMap.geoObjects.removeAll();

}

//  ЗАПРОС ДОБАВЛЕНИЯ ОБЪЯВЛЕНИЙ НА СТРАНИЦУ ОДНОГО ПОЛЬЗОВАТЕЛЯ ИЛИ ВСЕХ
function SearchHouse(NS) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "SellHouses.php",
            async: false,
            data:'nameNS='+JSON.stringify(NS),
            dataType: "text",
            success: function(data){
                Visitor = NS;
                
            }
        });
    return promise;
}

//  ДОБАВЛЕНИЕ ВСЕХ ОБЪЯВЛЕНИЙ НА СТРАНИЦУ
function AllAds() {
    ans = SearchHouse("All");
    const ins = document.getElementById('Table');
    ins.innerHTML = ans.responseText;
}

//  ПОИСК КОНКРЕТНОГО ОБЪЯВЛЕНИЯ НА КАРТЕ
function LinkAd(IdAddress) {
    //debugger;
    const adres = SearchAddress(IdAddress);
    getAddress(adres.responseText,1);

}

//  ЗАПРОС НА ПОИСК КОНКРЕТНОГО ОБЪЯВЛЕНИЯ
function SearchAddress(address) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "SellHouses.php",
            async: false,
            data:'ID='+JSON.stringify(address),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  СОЗДАНИЕ ВСПЛЫВАЮЩЕГО ОКНА ОБЪЯВЛЕНИЯ НА КАРТЕ
function SearchAd(addr) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "SellHouses.php",
            async: false,
            data:'Address='+JSON.stringify(addr),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise.responseText;
}


//  ОТОБРАЖЕНИЕ ВСЕХ ОБЪЯВЛЕНИЙ НА КАРТЕ (USER / ALL)
function AllmapMarkers() {
    var i;
    const chet = document.getElementsByClassName('FirstTd');
    for(g=0;g<chet.length;g++){
        i = parseInt(chet.item(g).id);
        var start = SearchAddress(i);
        getAddress(start.responseText,2);
    }
}

//  УДАЛЕНИЕ ВСЕХ МАРКЕРОВ
function deleted() {
    myMap.geoObjects.removeAll();
}

    //////////////////////
    //  РАБОТА С ФОРМОЙ //
    //////////////////////

//  УСТАНОВКА АТРИБУТОВ
function SetAtr(parametr,NumbRoom) {
    const opt = document.querySelectorAll("option");
    if(parametr != "")
    {
          opt.forEach(function(Item) 
        {
            if(Item.value == "") Item.removeAttribute("selected");
            else if(Item.value == parametr) Item.setAttribute("selected","selected");
        });  
    }

    if(NumbRoom != ""){
        opt.forEach(function(Item) 
        {
            if(Item.value == "") Item.removeAttribute("selected");
            else if(Item.value == NumbRoom || NumbRoom >= Item.value) Item.setAttribute("selected","selected");
        });  
    }
}

//  ОКНО СОЗДАНИЯ ОБЪЯВЛЕНИЯ
function FormAd() {
    
    list = LoadList("List");
    const vstavka = document.getElementById('okno');
    okno.style.width = "700px";
    okno.style.height = "600px";
    vstavka.innerHTML = list.responseText;
    const zag = okno.querySelector('h1');
    zag.innerHTML = "Новое Объявление";
    document.body.style.overflow = "hidden";
    document.location='#zatemnenie';

}

//  ОТПРАВКА ФОРМЫ ОБЪЯВЛЕНИЯ
function CreateFormAd() {
    
    const Select = $('#SelectArea').val();
    const Header = $('#HeaderArea').val();
   // const House = $('#HouseArea').val();
    const Descipt = $('#DesciptArea').val();
    const Room = $('#RoomArea').val();
    const Squ = $('#SquareArea').val();
    const Price = $('#PriceArea').val();

    //console.log(Adr);

    if((checkgetAddress==1) & (Header.length>0) & (Descipt.length>0) & (Adr.length>0) & (Price.length>0) & (Select !== null) & (Room !== null) & (Squ.length>0)){
        SendFormAd(Visitor,Select,Header,Adr,Descipt,Room,Squ,Price);
        addPost(Visitor);
        AllmapMarkers();
        Adr = 0;
        document.body.style.overflow = "auto";
        document.location='#';
    }
    else{
        const EForm = document.getElementById('ErrorForm');
        EForm.innerHTML = 'Пожалуйста, заполните все поля';
    }
    
}

//  ОКНО РЕДАКТИРОВАНИЯ ОБЪЯВЛЕНИЙ USER'А
function EditingAds(Visited) {

    list = LoadList(Visited);
    const vstavka = document.getElementById('okno');
    okno.style.width = "700px";
    okno.style.height = "600px";
    vstavka.innerHTML = list.responseText;
    Ads.style.display = "none";
    document.body.style.overflow = "hidden";
    document.location='#zatemnenie';

}

//  НАСТРОЙКИ ФОРМ
function LoadList(load, Id) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "SettingAds.php",
            async: false,
            data:'Settings='+JSON.stringify(load) + '&' +'ID='+JSON.stringify(Id),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  ДОБАВЛЕНИЯ В БД ДАННЫХ ФОРМЫ
function SendFormAd(Vr,St,Hr,Ho,Dt,Rm,Se,Pr) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "SendFormAd.php",
            async: false,
            data:'VISITOR='+JSON.stringify(Vr) + '&' +'TYPE='+JSON.stringify(St) + '&' + 'HEADER=' + JSON.stringify(Hr) + '&' + 'ADDRESS=' + JSON.stringify(Ho) + '&' + 'DESCRIPTION=' + JSON.stringify(Dt) + '&' + 'ROOM=' + JSON.stringify(Rm) + '&' + 'SQUARE=' + JSON.stringify(Se) + '&' + 'PRICE=' + JSON.stringify(Pr),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  ОКНО ИЗМЕНЕНИЯ ВЫБРАННОГО ОБЪЯВЛЕНИЯ
function EditForm(IdU) {
    list = LoadList("List",IdU);
    const EditingList = document.getElementById('okno');
    okno.style.width = "700px";
    okno.style.height = "600px";
    EditingList.innerHTML = list.responseText;
    const zag = okno.querySelector('h1');
    zag.innerHTML = "Изменить Объявление";
    checkgetAddress = 1;
    document.body.style.overflow = "hidden";
}

//  UPDATE ОБЪЯВЛЕНИЯ
function UpdateForm(Id) {

    const Select = $('#SelectArea').val();
    const Header = $('#HeaderArea').val();
    const House = $('#HouseArea').val();
    const Descipt = $('#DesciptArea').val();
    const Room = $('#RoomArea').val();
    const Squ = $('#SquareArea').val();
    const Price = $('#PriceArea').val();

    if((checkgetAddress==1) & (Header.length>0) & (Descipt.length>0) & (House.length>0) & (Price.length>0) & (Select !== null) & (Room !== null) & (Squ.length>0)){
        UpdateAd(Id,Visitor,Select,Header,House,Descipt,Room,Squ,Price);
        addPost(Visitor);
        AllmapMarkers();
        document.body.style.overflow = "auto";
        document.location='#';
    }
    else{
        const EForm = document.getElementById('ErrorForm');
        EForm.innerHTML = 'Пожалуйста, заполните все поля';
    }
    
}

//  ОБНОВЛЕНИЕ ДАННЫХ НА СЕРВЕРЕ
function UpdateAd(IdA,Vr,St,Hr,Ho,Dt,Rm, Se,Pr) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "UpdateAd.php",
            async: false,
            data:'ID='+JSON.stringify(IdA) + '&' +'VISITOR='+JSON.stringify(Vr) + '&' +'TYPE='+JSON.stringify(St) + '&' + 'HEADER=' + JSON.stringify(Hr) + '&' + 'ADDRESS=' + JSON.stringify(Ho) + '&' + 'DESCRIPTION=' + JSON.stringify(Dt) + '&' + 'ROOM=' + JSON.stringify(Rm) + '&' + 'SQUARE=' + JSON.stringify(Se) + '&' + 'PRICE=' + JSON.stringify(Pr),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  ОКНО УДАЛЕНИЕ ОБЪЯВЛЕНИЯ
function DeleteForm(Vis) {
    
    list = LoadList(Vis,"Delete");
    const vstavka = document.getElementById('okno');
    okno.style.width = "700px";
    okno.style.height = "600px";
    vstavka.innerHTML = list.responseText;
    Ads.style.display = "none";
    document.body.style.overflow = "hidden";
    document.location='#zatemnenie';

}

//  УДАЛЕНИЕ ОБЪЯВЛЕНИЯ С СЕРВЕРА
function DeleteAd(Id) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "DeleteAd.php",
            async: false,
            data:'ID='+JSON.stringify(Id),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  ДОБАВЛЕНИЕ ИНФОРМАЦИОННОГО ОКНА ОБЪЯВЛЕНИЯ 
function ShowFormAd(req) {
    var form = RequestFormAd(req,undefined);
    const InsForm = document.getElementById('okno');
    okno.style.width = "600px";
    okno.style.height = "230px";
    //okno.style.overflow = "visible";
    InsForm.innerHTML = form.responseText;
    //Ads.style.display = "none";
    document.body.style.overflow = "hidden";
    document.location='#zatemnenie';
}

//  ОТОБРАЖЕНИЕ ОКНА С ТЕЛЕФОНОМ ВЛАДЕЛЬЦА
function ShowTelephon(req_id){
    //alert(req_id);
    
    var tel_form = RequestFormAd(undefined,req_id);
    
    
    var insert_form_tel = document.getElementById('zatemnenie');
    var new_form = document.createElement('div');
    new_form.id='okno_tel';
    insert_form_tel.appendChild(new_form);


    //okno.style.width = "200px";
    //okno.style.height = "100px";
    new_form.innerHTML = tel_form.responseText;
    
}

//  СОЗДАНИЕ ИНФОРМАЦИОННОГО ОКНА ОБЪЯВЛЕНИЯ
function RequestFormAd(Id, s_tel) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "RequestFormAd.php",
            async: false,
            data:'ID='+JSON.stringify(Id) + '&' + 'OWNER=' + JSON.stringify(s_tel),
            dataType: "text",
            success: function(data){
                //console.log(data);
                
            }
        });
    return promise;
}

//  ДОБАВЛЕНИЕ ОКНА ФИЛЬТРОВ
function add_filters() {
    Adr = 0;
    form_fil = form_filters('load');
    const ins_fil = document.getElementById('Form_insert');
    ins_fil.innerHTML = form_fil.responseText;
    //Sel.style.display = 'block';
    ButtonDiv.style.display = 'block';
    //Form_fil.style.display = 'block';
}

//  СОЗДАНИЕ ОКНА ФИЛЬТРОВ
function form_filters(LD,ST,SR,PF_1,PF_2,S_1,S_2,AS) {
    const promise = $.ajax(
        {
            type:'POST',
            url: "add_form_fil.php",
            async: false,
            data:'NAMEOWNER='+JSON.stringify(Visitor) + '&' +'LOAD='+JSON.stringify(LD) + '&' + 'SEL_TYPE=' + JSON.stringify(ST) + '&' + 'SEL_ROOM=' + JSON.stringify(SR)+ '&' + 'PRICE_FIL_1=' + JSON.stringify(PF_1)+ '&' + 'PRICE_FIL_2=' + JSON.stringify(PF_2)+ '&' + 'SQUARE_1=' + JSON.stringify(S_1)+ '&' + 'SQUARE_2=' + JSON.stringify(S_2) + '&' + 'STREET=' + JSON.stringify(AS),
            dataType: "text",
            success: function(data){
                console.log('ok');
            }
        });
    return promise;
}

//  ПОИСК ОБЪЯВЛЕНИЙ ЧЕРЕЗ ФОРМУ ФИЛЬТРОВ
function FilterForm() {

    const Sel_type = $('#select').val();
    var Sel_room = $('#select_room').val();
    const Price_fil_1 = $('#Input_fil_1').val();
    const Price_fil_2 = $('#Input_fil_2').val();
    const Square_1 = $('#Input_fil_3').val();
    const Square_2 = $('#Input_fil_4').val();
   

    
    var form = form_filters('check',Sel_type,Sel_room,Price_fil_1,Price_fil_2,Square_1,Square_2,Adr);
    const ins_form = document.getElementById('Table');
    ins_form.innerHTML = form.responseText;
    myMap.geoObjects.removeAll();
    
}

// ОКНО РЕГИСТРАЦИИ
function Registr_form(){

    var reg_form = Registration('create',undefined,undefined,undefined,undefined);
    const vstavka = document.getElementById('okno');
    okno.style.width = "250px";
    okno.style.height = "300px";
    vstavka.innerHTML = reg_form.responseText;
    document.body.style.overflow = "hidden";
    document.location='#zatemnenie';

}

//  РЕГИСТРАЦИЯ
function Send_reg_form(){

    var nameReg = $('#nameReg').val();
    var passReg = $('#passReg').val();
    var telReg = $('#telReg').val();
    if ((!nameReg) || (nameReg.length > 10) || nameReg == "All"){
        alert('Неправильно введен логин');
        return;
    }
    if ((!passReg) || (passReg.length > 15)){
        alert('Неправильно введен пароль');
        return;
    }
    if ((!telReg) || (telReg.length > 12)){
        alert('Неправильно введен телефон');
        return;
    }

    if(nameReg,passReg,telReg){
        const promise =  Registration(undefined,'send',nameReg,passReg,telReg);
        if(promise.responseText){
            alert('Такой пользователь есть');
        }
        else{
            console.log('zareg');
            document.body.style.overflow = "auto";
            document.location='#';
            Form_REG.remove();
            
        }
    }

}

//  СОЗДАНИЕ ОКНА РЕГИСТРАЦИИ
function Registration(CR,Send,nameR,passR,telR){
    const promise = $.ajax(
        {
            type:'POST',
            url: "Registration.php",
            async: false,
            data:'CREATE_FORM='+JSON.stringify(CR) + '&' + 'SEND=' +JSON.stringify(Send) + '&' + 'NAMEREG=' +JSON.stringify(nameR)+ '&' + 'PASSREG=' +JSON.stringify(passR) + '&' + 'TELREG=' +JSON.stringify(telR),
            dataType: "text",
            success:function() {
                console.log('reg-ok');
            },
            error: function(dat){
                alert('error');
            }
        });
    return promise;
}



