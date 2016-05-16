<?php
/* @var $this AsignarinspectorController */
/* @var $model Asignarinspector */

$this->breadcrumbs=array(
	'Asignarinspectors'=>array('index'),
//	$model->id,
);

$this->menu=array(
	array('label'=>'List Asignarinspector', 'url'=>array('index')),
	array('label'=>'Create Asignarinspector', 'url'=>array('create')),
//	array('label'=>'Update Asignarinspector', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Asignarinspector', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asignarinspector', 'url'=>array('admin')),
);
?>

<h1>Detalles de la asignación realizada</h1>

<?php $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos,
        'attributes' => array(
            array('name' => 'nombre_ins', 'label' => 'Inspector responsable'),
            array('name' => 'hs', 'label' => 'hs: Asignación realizada'),
            array('name' => 'fecha', 'label' => 'Fecha: Asignacion realizada'),
            array('name' => 'empresa', 'label' => 'Empresa'),
            array('name' => 'sucursal', 'label' => 'Sucursal'),
            array('name' => 'direccion', 'label' => 'Direccion'),
        ),
        )
    ); ?>
