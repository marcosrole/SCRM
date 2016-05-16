<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */

$this->breadcrumbs=array(
	'Configalarmas'=>array('index'),
	$model->id,
);

$this->menu=array(		
	array('label'=>'Modificar Configuracion', 'url'=>array('update', 'id'=>$model->id)),	
);
?>

<h1>Cofiguracion actual</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'segCont',
		'porcCont',
                'pico',
                'cantPico',
		'segInter',
		
	),
)); ?>
