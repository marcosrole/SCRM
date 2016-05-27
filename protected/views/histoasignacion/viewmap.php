<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            #page {
                    margin-top: 5px;
                    margin-bottom: 5px;
                    margin-left: 110px;
                    background: white;
            }
            .mapa {
                width: 50%;
                float: left;
            }
            .detalle {
                display: inline-block;
                width: 40%;
                float: right;
            }
            p {
                margin: 0 0 10px;
                background-color: cornflowerblue;
            }
            .ventana_emergente{
                color: red;
                font-weight: bold;
            }
            .span-19 {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="mapa">
            <?php
        
            if(count($array_dispo) == 0){

                echo '<div class="alert alert-warning" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">Error:</span>
                        ADVERTENCIA: No se pueden mostrar los dispositivos
                        </div>';

                //Si no hay dispositivos.Muestro el mapa del Pais.
                Yii::import('ext.gmaps.*');        
                //Configuracion Basica
                $gMap = new EGMap();
                $gMap->setWidth(600);
                $gMap->setHeight(500);
                //Posicionamiento Central
                $gMap->setCenter(-36.359371, -62.632124);
                $gMap->setZoom(4);       
                $gMap->renderMap();
            }else{

                    Yii::import('ext.gmaps.*');

                    //Configuracion Basica
                    $gMap = new EGMap();
                    $gMap->setWidth(600);
                    $gMap->setHeight(500);


                    //Posicion del menú: Mapa, Relieve, etc 
                    $mapTypeControlOptions = array(
                        'position' => EGMapControlPosition::RIGHT_TOP,//Posicion del Menú
                        'style' => EGMap::MAPTYPECONTROL_STYLE_HORIZONTAL_BAR);//Estilo del Menú
                    $gMap->setOption('mapTypeControlOptions', $mapTypeControlOptions);


                    $lat_promedio=0;
                    $lon_promedio=0;
                    $cant_dispo=0;
                    foreach ($array_dispo as $key=>$value){
                        if($value[1]=='' || $value[2]==''){
                            $lat_promedio=$lat_promedio+0;
                            $lon_promedio=$lon_promedio+0;
                            
                        }else{
                            $lat_promedio=$lat_promedio+(double)$value[1];
                            $lon_promedio=$lon_promedio+(double)$value[2];
                            $cant_dispo++;
                        }
                        
                        
                //        *********************************
                //                Crear un markets:   
                //        *********************************
                    //Crear un icono para el market
                    //Verifico si hay una alarma para el dispositivo.
                    //Si existe,=> FIRE
                    //Sino => DRINK
                    
                    $alarma = Alarma::model()->findByAttributes(array('id_dis'=>$value[0], 'solucionado'=>0, 'preAlarma'=>0));
                    
                    if($alarma!=null){
                        $icon = new EGMapMarkerImage("http://" . $_SERVER['HTTP_HOST'] . "/SCRM/images/googlemap/fire.png");
                        $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$alarma{'id_tipAla'}));  
                    }else{
                        $icon = new EGMapMarkerImage("http://" . $_SERVER['HTTP_HOST'] . "/SCRM/images/googlemap/drink.png");                      
                    }
                                     
                    
                    $icon->setSize(32, 37);
                    $icon->setAnchor(16, 16.5);
                    $icon->setOrigin(0, 0);
                    
                    if($alarma!=null){
                        // Crear Informacion de ventana de mensaje
                        $linea1 = 'Dispositivo: ' . $value[0] . ' ' ;                        
                        $linea2 = 'Alarma: ' . $tipoAlarma{'descripcion'} . ' ' ;                        
                        $linea3 = 'Direccion: ' . $value[3] . ' ' ;
                            $url = "http://" . $_SERVER['HTTP_HOST'] . "/SCRM/asignarinspector/create";
                        $linea4 = '<a href= ' . $url . '>Solucionar</a> ';

                        $info_window_a = new EGMapInfoWindow(
                            "<div> " . $linea1 . " </div> " .
                            "<div class='ventana_emergente'> " . $linea2 . " </div> " .
                            "<div> " . $linea3 . " </div> " .
                            "<div> " . $linea4 . " </div> "                
                            );
                    }else {
                        // Crear Informacion de ventana de mensaje
                        $linea1 = 'Dispositivo: ' . $value[0] . ' ' ;                                                                       
                        $linea3 = 'Direccion: ' . $value[3] . ' ' ;                      

                        $info_window_a = new EGMapInfoWindow(
                            "<div> " . $linea1 . " </div> " .                            
                            "<div> " . $linea3 . " </div> "                                          
                            );
                    }
                    
                     
                    //Crear el market
                    if($value[1]!='' && $value[2]!=''){
                            $marker = new EGMapMarker($value[1], $value[2], array(
                                'title' => $value[3],
                                'icon' => $icon));
                            $marker->addHtmlInfoWindow($info_window_a); //Set la info de la ventana
                            $gMap->addMarker($marker);                            
                        }
                    
                    }
                    
                    if($cant_dispo==0){
                       //Posicionamiento Central
                        $gMap->setCenter(-36.359371, -62.632124);
                         $gMap->setZoom(4);   
                    }else{
                        
                    $gMap->setCenter($lat_promedio/$cant_dispo, $lon_promedio/$cant_dispo);
                    $gMap->setZoom(14); 
                    }
                           



                  $gMap->renderMap();

            }
                    ?>
        </div>
            
        <div class="detalle">
                    
            <?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); $cont=0;?>
                <div class="panel-group" id="accordion">

                    <?php foreach ($rawData as $datos){ $cont++;?>

                        <?php $id='item' . $cont; ?>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $id; ?>">
                                  Dispositivo: <?php echo $datos{'id'}?> - <?php echo $datos{'direccion'}?>
                              </a>
                            </h4>
                          </div>
                          <div id="<?php echo $id; ?>" class="panel-collapse collapse ">
                            <div class="panel-body">
                              <?php $this->widget(
                                    'booster.widgets.TbDetailView',
                                    array(
                                        'data' => $datos,
                                        'attributes' => array(
                                            array('name' => 'id', 'label' => 'Dispositivo'),
                                            array('name' => 'empresa', 'label' => 'Empresa'),
                                            array('name' => 'sucursal', 'label' => 'Sucursal'),
                                            array('name' => 'fechaAlta', 'label' => 'Fecha de Alta'),
                                            array('name' => 'direccion', 'label' => 'Direccion'),
                                            array('name' => 'alarma', 'label' => 'Alarma'),
                                        ),
                                        )
                                    ); ?>
                            </div>
                          </div>
                        </div>  

                    <?php }?>
                </div>
                <?php $this->endWidget(); ?>
            
            
            
        
        
        
        
    </body>
</html>
