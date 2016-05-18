<?php 
$self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
header("refresh:10; url=$self"); //Refrescamos cada 10 segundos
        $this->widget(
            'booster.widgets.TbHighCharts',
            array(
                'options' => array(
                    'title' => array('text' => 'Sensor Distancia' ),
                    'xAxis' => array(
                       'categories' => $datos_grafico['hs'],
                        'title' => array('text' => 'Tiempo')
                    ),
                    'yAxis' => array(
                       'title' => array('text' => 'Distancia')
                    ),
                    'series' => array(
                       array('name' => 'Distancia Sensada', 'data' => $datos_grafico['dist'],),
                       array('name' => 'Distancia Permitida' , 'data' => $datos_grafico['dist_permitido'],),

                    )
                 )
            )
        );
        ?>