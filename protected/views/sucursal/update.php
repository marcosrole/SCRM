<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('index')),
	array('label'=>'Crear Sucursal', 'url'=>array('create')),
	array('label'=>'Ver detalles de Sucursal', 'url'=>array('view', 'id'=>$sucursal->id)),
);
?>

<h1>Empresa: <?php echo $sucursal->id; ?></h1>
<?php $EmpresaSeleccionada = '[' . $empresaSelec{'cuit'} . ']';?>
<?php $this->renderPartial(
                        '_form',
                        array(
                            'sucursal'=>$sucursal,
                            'direccion'=>$direccion,
                            'empresa' => $empresa,
                            'localidad' => $localidad,                        
                            'zona' => $zona,
                            'listZona'=> $listZona,
                            'persona'=>$persona,
                            'checked'=>true,
                            'lista_localidades' => $lista_localidades,
                            'EmpresaSeleccionada' => $EmpresaSeleccionada,
                        )); ?>