<?php
/* @var $this ConfigalarmaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configalarmas',
);

$this->menu=array(
	array('label'=>'Create Configalarma', 'url'=>array('create')),
	array('label'=>'Manage Configalarma', 'url'=>array('admin')),
);
?>
<?php var_dump($dataProvider->getData());?>
<h1>Configalarmas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider[0],
	'itemView'=>'_view',
)); ?>
