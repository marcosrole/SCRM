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
	$model->id,
);

$this->menu=array(
	array('label'=>'List Accesodispositivo', 'url'=>array('index')),
	array('label'=>'Create Accesodispositivo', 'url'=>array('create')),
	array('label'=>'Update Accesodispositivo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Accesodispositivo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accesodispositivo', 'url'=>array('admin')),
);
?>

<h1>View Accesodispositivo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechaUltimo',
		'hsUltimo',
		'id_detDis',
		'id_dis_detDis',
	),
)); ?>
