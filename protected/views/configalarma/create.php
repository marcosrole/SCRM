
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
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */

$this->breadcrumbs=array(
	'Configalarmas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Alarma', 'url'=>array('alarma/admin')),
//	array('label'=>'Manage Configalarma', 'url'=>array('admin')),
);
?>

<h1>Configurar alarma</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 
                                          'minutosDisponibles'=>$minutosDisponibles,
                                           'porcentajeAceptacion'=>$porcentajeAceptacion)); ?>