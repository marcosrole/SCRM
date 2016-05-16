<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	$model->cuit,
);

$this->menu=array(
	array('label'=>'Listar Empresas', 'url'=>array('list')),
	array('label'=>'Crear Empresa', 'url'=>array('create')),	
        array('label'=>'Crear Sucursal', 'url'=>array('sucursal/create')),	
	array('label'=>'Administrar Empresa', 'url'=>array('admin')),
);

?>

<h1>Detalles de Empresa </h1>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cuit',
		'razonsocial',		
	),
)); ?>

<h2>Sucursales asociadas :</h2>
<?php 
 

foreach ($rawData as $datos){
        
    $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos,
        'attributes' => array(
            array('name' => 'nombre', 'label' => 'Sucursal'),
            array('name' => 'direccion', 'label' => 'Direccion'),
        ),
        )
    );
}
?>


