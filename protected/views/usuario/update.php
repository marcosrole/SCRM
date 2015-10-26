<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
//	'Usuarios'=>array('index'),
//	$usuario->name=>array('view','id'=>$usuario->id),
//	'Update',
);

$this->menu=array(
	array('label'=>'Listar Usuario', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Cambiar contraseña', 'url'=>array('password', 'id'=>$usuario->id)),
//	array('label'=>'Manage Usuario', 'url'=>array('admin')),
);
?>

<h1>Actualizar Usuario <?php ?></h1>


<?php $this->renderPartial('_form',
                        array(
                            'usuario'=>$usuario,
                            'persona'=>$persona,
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'lista_localidades'=>$lista_localidades,
                            'inspector'=>$inspector,
                            'update'=>$update,
                            ));
 ?>