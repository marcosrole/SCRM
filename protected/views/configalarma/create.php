<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */

$this->breadcrumbs=array(
	'Configalarmas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Configalarma', 'url'=>array('index')),
	array('label'=>'Manage Configalarma', 'url'=>array('admin')),
);
?>

<h1>Configurar alarma</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>