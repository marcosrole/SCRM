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

<?php $this->menu=array(
	array('label'=>'Cargar Dispositivo', 'url'=>array('dispositivo/create')),	
        array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
        
);

?>

<h1>
    Dispositivos almacenados 
</h1>

<div class="form">
<?php
$modelo = new Dispositivo();

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'dispositivo-grid-list',
    'dataProvider' => $modelo->search(),
    'columns' => array(
        array(
            'name' => 'id',
            'header'=>'ID',
            'htmlOptions'=>array('width'=>'10%px'),            
        ),
        array(
            'name' => 'mac',
            'header'=>'MAC',
            'htmlOptions'=>array('width'=>'40%'),           
        ),
        array(
            'name' => 'modelo',
            'header'=>'Modelo',
            'htmlOptions'=>array('width'=>'2O%'),                      
        ),
        array(
            'name' => 'version',
            'header'=>'Version',
            'htmlOptions'=>array('width'=>'2O%'),
        ),
         array(
            'name' => 'tiempo',
            'header'=>'tiempo',
             'htmlOptions'=>array('width'=>'10%'),
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
</div>

    
