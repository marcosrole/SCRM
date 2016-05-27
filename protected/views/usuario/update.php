<?php
        $this->widget('booster.widgets.TbAlert', array(
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array( // configurations per alert type
                // success, info, warning, error or danger
                'success' => array('closeText' => '&times;'),
                'info', // you don't need to specify full config
                'warning' => array('closeText' => false),
                
            ),
        ));
?>

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
                            'array_rol'=> $array_rol,
                            'rol'=>$rol,
                            'lista_localidades'=>$lista_localidades,
                            'listZona'=>  CHtml::listData($zona->findAll(), 'id', 'nombre'),
                            'zona'=>$zona,
                            'update'=>$update,
                            ));
 ?>