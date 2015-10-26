<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	$model->cuit=>array('view','id'=>$model->cuit),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Empresa', 'url'=>array('list')),
	array('label'=>'Create Empresa', 'url'=>array('create')),
	array('label'=>'Ver Empresa', 'url'=>array('view', 'id'=>$empresa->cuit)),
	array('label'=>'Administrar Empresa', 'url'=>array('admin')),
);
?>

<h1>Modificar Empresa: <?php echo $empresa->razonsocial; ?></h1>


<?php $this->renderPartial('_form', array(
                    'empresa' => $empresa,
                    'persona' => $persona,
                    'direccion' => $direccion,
                    'localidad' => $localidad,
                    'lista_localidades' => $lista_localidades,                                        
                ));?>