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
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Alarmas',
);

$this->menu=array(
	array('label'=>'Create Alarma', 'url'=>array('create')),
	array('label'=>'Manage Alarma', 'url'=>array('admin')),
);
?>

<h1>Alarmas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
