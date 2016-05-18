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

/* @var $this CalibracionController */
/* @var $calibracion Calibracion */

$this->breadcrumbs=array(
	'Calibracions'=>array('index'),
//	$calibracion->id,
);

$this->menu=array(
	array('label'=>'Listar Calibraciones', 'url'=>array('list')),
	array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
//	array('label'=>'Modificar datos', 'url'=>array('update', 'id'=>$calibracion->id)),
//	array('label'=>'Eliminar registro', 'url'=>array('eliminar', 'id'=>$calibracion->id), 'linkOptions'=>array('confirm'=>'Desea eliminar el registro?')),
	
);
?>

<h1>Detalles de valores de aceptación <?php ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$datos,
	'attributes'=>array(		
		'db',
		'dist',
		'sucursal',
		'direccion',
	),
)); ?>
