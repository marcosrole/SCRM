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
	$model->id,
);

$this->menu=array(		
	array('label'=>'Modificar Configuracion', 'url'=>array('update', 'id'=>$model->id)),	
);
?>

<h1>Cofiguracion actual</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'segCont',
		'porcCont',
                'segInt',
                'porcInt',
                'segDis',
                'porcDis',
                'recibirAlaDistancia',
                'recibirAlaIntermitente',
                'recibirAlaContinuo',
                'tolResponsable',
		
		
	),
)); ?>
