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
<style>
p {
    background-color: #0099FF;
}

</style>
<?php
/* @var $this AsignarinspectorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asignarinspectors',
);

$this->menu=array(
	array('label'=>'Crear Asignacion', 'url'=>array('create')),
	array('label'=>'Eliminar Asignaciones', 'url'=>array('admin')),
);
?>

<h1>Asignaciones Realizadas</h1>

<?php foreach ($datos as $dato){ ?>
    <p>
       . 
    </p>
    
    <?php $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $dato,
        'attributes' => array(
            array('name' => 'encargado', 'label' => 'Responsable de la sucursal'),
            array('name' => 'fechahsDue', 'label' => 'Horario de aviso al Responsable'),
            array('name' => 'inspector', 'label' => 'Inspector responsable'),            
            array('name' => 'fechahsIns', 'label' => 'Horario de aviso al Inspector'),            
            array('name' => 'alarma', 'label' => 'Alarma generada'),
            array('name' => 'nombre_emp', 'label' => 'Empresa'),
            array('name' => 'nombre_suc', 'label' => 'Sucursal'),
            array('name' => 'direccion', 'label' => 'Direccion'),
        ),
        )
    ); ?>
<?php }?>
