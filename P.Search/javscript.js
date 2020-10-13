$(function(){

    // КАРТА

    ymaps.ready(init).then(AllmapMarkers);
    //ymaps.ready(init);

    function init()
    {
        var myPlacemark;
        var posX = 131.9007812;
        var posY = 43.1275961;
        // Создание карты.
        window.myMap = new ymaps.Map("map", {

            center: [posY, posX],
            zoom: 11,
            controls: ['zoomControl']
        }, {
            searchControlProvider: 'yandex#search'
            
        });

        
        myMap.events.add('click', function (e){
            var CoordsName = e.get('coords');
            
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(CoordsName);
            }
            
            getAddress(CoordsName,0);

        });

        myMap.geoObjects.events.add('click', function (e) {
            if(e.get('target') == Blue_point)
            myMap.geoObjects.remove(Blue_point)
        });
    }
    

    
    
    // ФУНКЦИОНАЛ
    
    window.onload = AllAds();
    //window.onresize = function(event) {};
    var k = 1.1;
    $(window).resize(function(){
        $('#map').height($('#map').width() / k);
        $('#Open').height($('#Open').width() / k);
        //$('#Ads').height($('#Ads').width() / k);
        //$('#Table').height($('#Table').width() / k);
        $('#Form_fil').height($('#Form_fil').width() / k);
        //$('#Settings').height($('#Settings').width() / k);
        $('.change_set').height($('.change_set').width() / k);
        //$('#Search').height($('#Search').width() / k);
        $('#okno').height($('#okno').width() / k);

    });

    $('#SendButton').on('click', function(){

        var nameUs = $('#nameUser').val();
        if (!(nameUs)){
            alert('Введите логин');
            return;
        }
    
        var passUs = $('#passUser').val();
        if (!(passUs)){
            alert('Введите пароль');
            return;
        }

        if(nameUs,passUs){
            const promise = SendMessage(nameUs,passUs);
            if (promise.responseText){
                promise.then(addPost(nameUs))
                promise.then(AllmapMarkers())
                //promise.then(add_filters())
                //$("#DeleteAd").css("background-color","#f7a1a18a");
                $('#Settings').addClass('animate__backInRight');
                Settings.style.display = 'block';

                
                //ButtonDiv.style.display = 'none';
                //Filters.style.display = 'none';
                //$('.menu_fil').removeClass('menu_fil_click');
                
            }       
            else{
                alert("Неверный логин или пароль");
            }
        }

        

    });

    $('#ViewAds').on('click', function(){

        Settings.style.display = 'none';
        //ViewAds.style.display = 'none';
        deleted();
        AllAds();
        AllmapMarkers();
        add_filters();
        $('#Settings').removeClass('animate__backInRight');
        $('.menu_fil').removeClass('menu_fil_click'); 

        
    });

    $('#searchButton').on('click', function(){

        var searchLine = $('#SearchLine').val();
        getAddress(searchLine,1);
        
    });

    $('#DeleteAd').on('click', function(){

        //deleted();
        DeleteForm(Visitor);
        
    });

    $('#CreateAd').on('click', function(){

        FormAd();
        
    });

    $('#EditAd').on('click', function(){

        EditingAds(Visitor);
        
    });

    $('#But_fil').on('click', function(){
        FilterForm();
        AllmapMarkers();
    });

    $('#Show_Fil').on('click', function(){

        if($('.menu_fil').hasClass('menu_fil_click')){
            $('.menu_fil').removeClass('menu_fil_click');
        }
        else if($('.menu_fil').hasClass('menu_fil')){
            But_fil.style.display = 'block';
            add_filters();
            $('.menu_fil').addClass('menu_fil_click');            
        }

    });

    $('#Registr_button').on('click', function(){
        Registr_form();
    });

    

});
