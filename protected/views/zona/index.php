<?php
/* @var $this GruposucursalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Gruposucursals',
);

$this->menu=array(
	array('label'=>'Crear Sucursal', 'url'=>array('sucursal/create')),
	array('label'=>'Agregar Zona', 'url'=>array('create')),
);
?>

<h1>Zonas Almacenadas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>