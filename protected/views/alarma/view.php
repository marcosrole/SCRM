<?php
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
//	'Alarmas'=>array('index'),
//	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Alarmas', 'url'=>array('admin')),	
	array('label'=>'Solucionar Inconveniente', 'url'=>array('')),
	array('label'=>'Eliminar Alarma', 'url'=>array('eliminar', 'id'=>$model->id), 'linkOptions'=>array('confirm'=>'Desea eliminar el registro?')),
	
);
?>

<h1>Detalle de Alarma <?php  ?></h1>

<?php $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos,
        'attributes' => array(
            array('name' => 'id', 'label' => 'ID Alarma'),
            array('name' => 'descripcion', 'label' => 'Descripcion'),
            array('name' => 'vesperado', 'label' => 'Valor Esperado'),
            array('name' => 'vactual', 'label' => 'Valor Actual'),
            array('name' => 'sucursal', 'label' => 'Sucursal'),
            array('name' => 'empresa', 'label' => 'Empresa'),
            array('name' => 'direccion', 'label' => 'Direccion'),
            array('name' => 'fecha', 'label' => 'Fecha'),
            array('name' => 'hs', 'label' => 'HS'),
        ),
        )
    );
?>

