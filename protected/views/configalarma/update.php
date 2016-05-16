<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */

$this->breadcrumbs=array(
	'Configalarmas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(	
	array('label'=>'Ver Configuracion actual', 'url'=>array('view', 'id'=>$model->id)),	
);
?>

<h1>Modificar configuracion de Alarma</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>