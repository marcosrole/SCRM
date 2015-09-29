<?php
        $this->widget('booster.widgets.TbAlert', array(
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array( // configurations per alert type
                // success, info, warning, error or danger
                'success' => array('closeText' => '&times;'),
                'info', // you don't need to specify full config
                'warning' => array('closeText' => false),
                'error' => array('closeText' => false),                
            ),
        ));
        ?>

<h1>
    Dispositivos almacenados 
</h1>


<?php
$modelo = new Dispositivo();

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'dispositivo-grid-list',
    'dataProvider' => $modelo->search(),
    'filter' => $modelo,
    'columns' => array(
        array(
            'name' => 'id',
            'header'=>'Nro. Identificación'
        ),
        array(
            'name' => 'mac',
            'header'=>'MAC'
        ),
        array(
            'name' => 'modelo',
            'header'=>'Modelo'
        ),
        array(
            'name' => 'version',
            'header'=>'Version'
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('width' => '40'), //ancho de la columna
            'template' => '{view}', // botones a mostrar
            'buttons'=>array(
                "view"=>array(
                    'label'=>'Detalles',                    
                    'url'=> 'Yii::app()->createUrl("/DetalleDispo/VerDetalle?id=$data->id")'
                    )),
        ),
    ),
));
?>

    
