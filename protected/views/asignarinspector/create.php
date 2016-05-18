<?php
$this->widget('booster.widgets.TbAlert', array(
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array(// configurations per alert type
        // success, info, warning, error or danger
        'success' => array('closeText' => '&times;'),
        'info', // you don't need to specify full config
        'warning' => array('closeText' => false),
        'error' => array('closeText' => false),
    ),
));
?>
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