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
	'Manage',
);

$this->menu=array(
	array('label'=>'List Configalarma', 'url'=>array('index')),
	array('label'=>'Create Configalarma', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'configalarma-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'segCont',
		'porcCont',
		'segInter',
		'cantPico',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
