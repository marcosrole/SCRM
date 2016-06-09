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
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Empresas', 'url'=>array('list')),
        array('label'=>'Listar Sucursales', 'url'=>array('sucursal/index')),
	array('label'=>'Administrar Empresas', 'url'=>array('admin')),
        array('label'=>'Crear Sucursal', 'url'=>array('sucursal/create')),
);
?>

<h1>Crear nueva Empresa</h1>

<?php $this->renderPartial('_form', array(
                    'empresa' => $empresa,                    
    
                )); ?>