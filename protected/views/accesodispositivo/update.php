<?php
/* @var $this AccesodispositivoController */
/* @var $model Accesodispositivo */

$this->breadcrumbs=array(
	'Accesodispositivos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accesodispositivo', 'url'=>array('index')),
	array('label'=>'Create Accesodispositivo', 'url'=>array('create')),
	array('label'=>'View Accesodispositivo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Accesodispositivo', 'url'=>array('admin')),
);
?>

<h1>Update Accesodispositivo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>