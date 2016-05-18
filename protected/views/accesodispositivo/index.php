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
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accesodispositivos',
);

$this->menu=array(
	array('label'=>'Create Accesodispositivo', 'url'=>array('create')),
	array('label'=>'Manage Accesodispositivo', 'url'=>array('admin')),
);
?>

<h1>Accesodispositivos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
