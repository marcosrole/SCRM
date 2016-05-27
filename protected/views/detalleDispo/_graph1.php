<?php 
$self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
header("refresh:10; url=$self"); //Refrescamos cada 10 segundos
        $this->widget(
            'booster.widgets.TbHighCharts',
            array(
                'options' => array(
                    'credits' => array('enabled' => false),
                    'title' => array('text' => 'Presion Sonora (dB)'),
                    'xAxis' => array(
                       'categories' => $datos_grafico['hs'],
                        'title' => array('text' => 'Tiempo')
                    ),
                    'yAxis' => array(
                       'title' => array('text' => 'Presion Sonora')
                    ),
                    'series' => array(
                       array('name' => 'dB Sensado ' , 'data' => $datos_grafico['db'],),
                       array('name' => 'dB Permitido ', 'data' => $datos_grafico['db_permitido'],),

                    )
                 )
            )
        );
        ?>