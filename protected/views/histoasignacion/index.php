<?php
/* @var $this HistoasignacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Histoasignacions',
);

$this->menu=array(
	array('label'=>'Create Histoasignacion', 'url'=>array('create')),
	array('label'=>'Manage Histoasignacion', 'url'=>array('admin')),
);
?>

<h1>Histoasignacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
