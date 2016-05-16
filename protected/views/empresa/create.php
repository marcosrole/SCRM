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

<h1>Crear Empresa</h1>

<?php $this->renderPartial('_form', array(
                    'empresa' => $empresa,
                    'persona' => $persona,
                    'direccion' => $direccion,
                    'localidad' => $localidad,
                    'lista_localidades' => $lista_localidades,
    'checked' => $checked, 
                )); ?>