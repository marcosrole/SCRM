<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->breadcrumbs=array(
	'Sucursals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('sucursal/index')),
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
                            'checked' => $checked,
                            'persona' => $persona,
                            'zona' => $zona,
                            'listZona'=> $listZona,
                            'lista_localidades' => $lista_localidades,
                            'EmpresaSeleccionada' => '[]',
                        )); ?>