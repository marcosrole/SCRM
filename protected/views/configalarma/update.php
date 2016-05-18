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
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(	
	array('label'=>'Ver Configuracion actual', 'url'=>array('view', 'id'=>$model->id)),	
);
?>

<h1>Modificar configuracion de Alarma</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>