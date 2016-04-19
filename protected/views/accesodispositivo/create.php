<?php
/* @var $this AccesodispositivoController */
/* @var $model Accesodispositivo */

$this->breadcrumbs=array(
	'Accesodispositivos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accesodispositivo', 'url'=>array('index')),
	array('label'=>'Manage Accesodispositivo', 'url'=>array('admin')),
);
?>

<h1>Create Accesodispositivo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>