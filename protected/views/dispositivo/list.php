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

    
