<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('list'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Usuario', 'url'=>array('index')),
	array('label'=>'Administrar Usuario', 'url'=>array('admin')),
);
?>

<h1>Crear Usuario</h1>

 <?php $this->renderPartial('_form',
                        array(
                            'usuario'=>$usuario,
                            'persona'=>$persona,                            
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'array_rol'=> $array_rol,
                            'rol'=>$rol,
                            'lista_localidades'=>$lista_localidades,
                            'listZona'=>  CHtml::listData($zona->findAll(), 'id', 'nombre'),
                            'zona'=>$zona,
                            'update'=>false,
                            ));
 ?>

