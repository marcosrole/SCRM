<?php
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
	'Alarmas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Alarma', 'url'=>array('index')),
	array('label'=>'Create Alarma', 'url'=>array('create')),
	array('label'=>'View Alarma', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Alarma', 'url'=>array('admin')),
);
?>

<h1>Update Alarma <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>