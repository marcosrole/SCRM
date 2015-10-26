<?php
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
	'Alarmas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Alarma', 'url'=>array('index')),
	array('label'=>'Manage Alarma', 'url'=>array('admin')),
);
?>

<h1>Create Alarma</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>