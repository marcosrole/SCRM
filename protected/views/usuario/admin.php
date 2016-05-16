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
));?>
<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Usuario', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),
);

?>

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

<h1>Administrar Usuarios</h1>

<p>

</p>

<?php
$this->widget('booster.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),        
        'filter' => $model,
         'columns' => array(                
                array(
                    'name' => 'name',
                    'header'=>'Nombre'
                ),                                                            
             array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{delete} {update} {NivelAcceso}', // botones a mostrar
                    'buttons' => array(
                        'delete' => array
                        (
                            'label'=>'Eliminar',
                            'icon'=>'glyphicon glyphicon-trash',

                            'click' => 'function(){return confirm("Desea eliminar el Usuario?");}',
                            'url'=> 'Yii::app()->createUrl("usuario/eliminar?id=$data->id")',                                                    
                            
                        ),                        
                        'update' => array(
                            'label' => 'Actualizar',                                                         
                            'url'=> 'Yii::app()->createUrl("/usuario/update?id=$data->id")'
                        ),                
                        'NivelAcceso' => array(
                            'label' => 'Nivel Acceso',                                                         
                            'icon'=>'glyphicon glyphicon-user',
                            'url'=> 'Yii::app()->createUrl("/nivelesmenu/create?id_usr=$data->id")'
                        ),
                    ),
                    //'htmlOptions'=>array('style'=>'width: 120px'),
                    ),
             ),
    ));
        
?>