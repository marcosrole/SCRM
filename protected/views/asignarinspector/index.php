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
            array('name' => 'inspector', 'label' => 'Inspector responsable'),
            array('name' => 'hs', 'label' => 'Hs'),
            array('name' => 'fecha', 'label' => 'Fecha'),
            array('name' => 'alarma', 'label' => 'Alarma'),
            array('name' => 'nombre_emp', 'label' => 'Empresa'),
            array('name' => 'nombre_suc', 'label' => 'Sucursal'),
            array('name' => 'direccion', 'label' => 'Direccion'),
        ),
        )
    ); ?>
<?php }?>

