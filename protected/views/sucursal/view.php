<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->breadcrumbs=array(
	'Sucursals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Sucursal', 'url'=>array('index')),
	array('label'=>'Crear Sucursal', 'url'=>array('create')),
//	array('label'=>'Actualizar datos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Sucursal', 'url'=>'#', 'linkOptions'=>array('confirm'=>'¿Esta seguro que desea eliminar la sucursal?')),
	array('label'=>'Administrar Sucursal', 'url'=>array('admin')),
);
?>

<h1>Detalles Sucursal: <strong><?php echo $model->nombre; ?></strong> </h1>

<?php $this->widget(
        'booster.widgets.TbDetailView',
        array(
            'data' => $datos,
            'attributes' => array(
                array('name' => 'cuit', 'label' => 'CUIT'),
                array('name' => 'empresa', 'label' => 'Empresa'),
                array('name' => 'sucursal', 'label' => 'Sucursal'),
                array('name' => 'zona', 'label' => 'Zona'),
                array('name' => 'direccion', 'label' => 'Direccion'),
                array('name' => 'localidad', 'label' => 'Localidad') ),
            )
); ?>
