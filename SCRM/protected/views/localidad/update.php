<?php
/* @var $this LocalidadController */
/* @var $model Localidad */

$this->breadcrumbs=array(
	'Localidads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Localidad', 'url'=>array('index')),
	array('label'=>'Create Localidad', 'url'=>array('create')),
	array('label'=>'View Localidad', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Localidad', 'url'=>array('admin')),
);
?>

<h1>Update Localidad <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>