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
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configalarmas',
);

$this->menu=array(
	array('label'=>'Create Configalarma', 'url'=>array('create')),
	array('label'=>'Manage Configalarma', 'url'=>array('admin')),
);
?>
<?php var_dump($dataProvider->getData());?>
<h1>Configalarmas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider[0],
	'itemView'=>'_view',
)); ?>
