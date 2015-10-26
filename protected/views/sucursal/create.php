<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->breadcrumbs=array(
	'Sucursals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('empresa/list')),
	array('label'=>'Modificar Sucursal', 'url'=>array('admin')),
);
?>

<h1>Crear Sucursal</h1>

 <?php $this->renderPartial(
                        '_form',
                        array(
                            'sucursal'=>$sucursal,
                            'direccion'=>$direccion,
                            'empresa' => $empresa,
                            'localidad' => $localidad,                        
                            'lista_localidades' => $lista_localidades,
                        )); ?>