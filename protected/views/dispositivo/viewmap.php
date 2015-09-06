<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        Yii::import('ext.gmaps.*');
        
        //Configuracion Basica
        $gMap = new EGMap();
        $gMap->setWidth(800);
        $gMap->setHeight(600);
              
        
        //Posicion del menú: Mapa, Relieve, etc 
        $mapTypeControlOptions = array(
            'position' => EGMapControlPosition::RIGHT_TOP,//Posicion del Menú
            'style' => EGMap::MAPTYPECONTROL_STYLE_HORIZONTAL_BAR);//Estilo del Menú
        $gMap->setOption('mapTypeControlOptions', $mapTypeControlOptions);

        
        $lat_promedio=0;
        $lon_promedio=0;
        $cant_dispo=0;
        
        foreach ($array_dispo as $key=>$value){
            $lat_promedio=$lat_promedio+$value[1];
            $lon_promedio=$lon_promedio+$value[2];
            $cant_dispo++;
            
        // Crear Informacion de ventana de mensaje
            $linea1 = 'Dispositivo: ' . $value[0] . ' ' ;
            $linea2 = 'Coordenadas: ' . $value[1] . ', ' . $value[2] . ' ' ;
            $linea3 = '<a href= "http://facebook.com/rolemarcos poner" >Mi facebook</a> ';
            
        $info_window_a = new EGMapInfoWindow(
                "<div> " . $linea1 . " </div> " .
                "<div> " . $linea2 . " </div> " .
                "<div> " . $linea3 . " </div> "                
                );


    //        *********************************
    //                Crear un markets:   
    //        *********************************
        //Crear un icono para el market
        $icon = new EGMapMarkerImage("http://google-maps-icons.googlecode.com/files/home.png");
        $icon->setSize(32, 37);
        $icon->setAnchor(16, 16.5);
        $icon->setOrigin(0, 0);
        
        //Crear el market
        $marker = new EGMapMarker($value[1], $value[2], array(
            'title' => $value[3],
            'icon' => $icon));
        $marker->addHtmlInfoWindow($info_window_a); //Set la info de la ventana

        $gMap->addMarker($marker);
}
           
        
        //Posicionamiento Central
        $gMap->setCenter($lat_promedio/$cant_dispo, $lon_promedio/$cant_dispo);
        $gMap->setZoom(14);        
                
                
        
      $gMap->renderMap();

        
        ?>
    </body>
</html>
