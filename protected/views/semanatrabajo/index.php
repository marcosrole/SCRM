<?php
/* @var $this SemanatrabajoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Semanatrabajos',
);

$this->menu=array(
	array('label'=>'Create Semanatrabajo', 'url'=>array('create')),
	array('label'=>'Manage Semanatrabajo', 'url'=>array('admin')),
);
?>

<h1>Semanatrabajos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
