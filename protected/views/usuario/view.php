 <?php
        $this->widget('booster.widgets.TbAlert', array(
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array(// configurations per alert type
                // success, info, warning, error or danger
                'success' => array('closeText' => '&times;'),
                'info', // you don't need to specify full config
                'warning' => array('closeText' => false),
                'error' => array('closeText' => false),
            ),
        ));
        ?>
<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->menu=array(
	array('label'=>'Asignar Permisos', 'url'=>array('permisos/usuario')),
	array('label'=>'Crear Usuario', 'url'=>array('usuario/create')),
	array('label'=>'Modificar datos', 'url'=>array('update', 'id'=>$usuario->id)),	
);
?>

<?php
$this->widget('booster.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $usuario->search(),        
        'filter' => $usuario,
         'columns' => array(
                array(
                    'name' => 'id',
                    'header'=>'#'
                ),
                array(
                    'name' => 'name',
                    'header'=>'Nombre'
                ),
                array(
                    'name' => 'pass',
                    'header'=>'Contraseña'
                ),                
                array(
                    'name' => 'nivel',
                    'header'=>'Nivel de Acceso'
                ),             
             array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{delete} {update}', // botones a mostrar
                    'buttons' => array(
                        'delete' => array(
                            'label' => 'Detalles',                                                         
                            'url'=> 'Yii::app()->createUrl("/Calibracion/view?id=$data->id")'
                        ),                        
                        'update' => array(
                            'label' => 'Actualizar',                                                         
                            'url'=> 'Yii::app()->createUrl("/usuario/update?id=$data->id")'
                        ),                
                    ),
                    //'htmlOptions'=>array('style'=>'width: 120px'),
                    ),
             ),
    ));
        
?>