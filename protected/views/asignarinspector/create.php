<?php
/* @var $this AsignarinspectorController */
/* @var $dataInspectores DatosInspecores */

$this->breadcrumbs=array(
	'Asignarinspectors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Ver Asignaciones', 'url'=>array('index')),
	array('label'=>'Eliminar Asignaciones', 'url'=>array('admin')),
);

?>

<h1>Asignar Inspector</h1>

<?php $this->renderPartial('_form', array(
    'DataProviderAlarmas'=>$DataProviderAlarmas,
     'DataProviderInspector'=>$DataProviderInspector,
    'AasignarInspector' => $AasignarInspector,
    )); ?>