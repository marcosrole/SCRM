<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */

$this->breadcrumbs=array(
	'Permisosusuarios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Permisosusuario', 'url'=>array('index')),
	array('label'=>'Create Permisosusuario', 'url'=>array('create')),
	array('label'=>'View Permisosusuario', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Permisosusuario', 'url'=>array('admin')),
);
?>

<h1>Update Permisosusuario <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>