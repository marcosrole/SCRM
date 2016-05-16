<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('index')),
	array('label'=>'Crear Sucursal', 'url'=>array('create')),
	array('label'=>'View Sucursal', 'url'=>array('view', 'id'=>$sucursal->id)),
	array('label'=>'Manage Sucursal', 'url'=>array('admin')),
);
?>

<h1>Update Sucursal <?php echo $sucursal->id; ?></h1>

<?php $this->renderPartial(
                        '_form',
                        array(
                            'sucursal'=>$sucursal,
                            'direccion'=>$direccion,
                            'empresa' => $empresa,
                            'localidad' => $localidad,                        
                            'grupoSucural' => $grupoSucural,
                            'lista_localidades' => $lista_localidades,
                        )); ?>