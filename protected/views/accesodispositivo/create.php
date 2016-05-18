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
/* @var $this AccesodispositivoController */
/* @var $model Accesodispositivo */

$this->breadcrumbs=array(
	'Accesodispositivos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accesodispositivo', 'url'=>array('index')),
	array('label'=>'Manage Accesodispositivo', 'url'=>array('admin')),
);
?>

<h1>Create Accesodispositivo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>