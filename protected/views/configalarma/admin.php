<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */

$this->breadcrumbs=array(
	'Configalarmas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Configalarma', 'url'=>array('index')),
	array('label'=>'Create Configalarma', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'configalarma-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'segCont',
		'porcCont',
		'segInter',
		'cantPico',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
