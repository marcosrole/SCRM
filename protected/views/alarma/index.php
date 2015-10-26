<?php
/* @var $this AlarmaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Alarmas',
);

$this->menu=array(
	array('label'=>'Create Alarma', 'url'=>array('create')),
	array('label'=>'Manage Alarma', 'url'=>array('admin')),
);
?>

<h1>Alarmas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
