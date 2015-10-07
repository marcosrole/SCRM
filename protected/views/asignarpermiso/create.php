<?php
/* @var $this AsignarpermisoController */
/* @var $model Asignarpermiso */

$this->breadcrumbs=array(
	'Asignarpermisos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Asignarpermiso', 'url'=>array('index')),
	array('label'=>'Manage Asignarpermiso', 'url'=>array('admin')),
);
?>

<h1>Create Asignarpermiso</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>