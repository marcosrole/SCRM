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
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
	'Alarmas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Alarma', 'url'=>array('index')),
	array('label'=>'Create Alarma', 'url'=>array('create')),
	array('label'=>'View Alarma', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Alarma', 'url'=>array('admin')),
);
?>

<h1>Update Alarma <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>