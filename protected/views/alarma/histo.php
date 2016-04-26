<?php ?>

 <?php
$this->widget('booster.widgets.TbAlert', array(
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array(// configurations per alert type
        // success, info, warning, error or danger
        'success' => array('closeText' => '&times;'),
        'info', // you don't need to specify full config
        'warning' => array('closeText' => false),
        'error' => array('closeText' => false),
    ),
));
?>



<?php
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
	'Alarmas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Agregar Dispositivo', 'url'=>array('dispositivo/create')),
        array('label'=>'Calibrar Dispositivo', 'url'=>array('Calibracion/create?id_disp=')),
	array('label'=>'Agregar Sucursal', 'url'=>array('sucursal/create')),
        array('label'=>'Eliminar todo', 'url'=>'#', 'linkOptions'=>array('onclick'=>'show_confirm()')),
        array('label'=>'Solucionar Inconveniente', 'url'=>array('asignarinspector/create')),
        
);
?>

<h1>Alarmas Intervendias</h1>

<p>
<b>Nota:</b> 
</p>

<div class="form">
    <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderAlarma,
            'columns' => array( 
                array(
                    'name' => 'id',
                    'header'=>'#'
                ),                                
                array(
                    'name' => 'fecha',
                    'header'=>'Fecha'
                ),                        
                array(
                    'name' => 'hs',
                    'header'=>'Hora'
                ),                        
                array(
                    'name' => 'alarma',
                    'header'=>'Descripcion'
                ), 
                array(
                    'name' => 'solucionado',
                    'header'=>'Solucionado',
                    'value'=>'$data["solucionado"]== 0 ? "NO" : "SI"',  
                ),
                
            ),

        ));
    ?> 
</div>
    

