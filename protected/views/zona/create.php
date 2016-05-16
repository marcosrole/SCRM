<?php
/* @var $this GruposucursalController */
/* @var $model Gruposucursal */

$this->breadcrumbs=array(
	'Gruposucursals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Zonas', 'url'=>array('index')),
	array('label'=>'Crear Sucursal', 'url'=>array('sucursal/create')),
);
?>

<h1>Create Gruposucursal</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>