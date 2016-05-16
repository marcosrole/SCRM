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
                'error' => array('closeText' => false),                
            ),
        ));
        ?>
<?php
/* @var $this SemanatrabajoController */
/* @var $model Semanatrabajo */

$this->breadcrumbs=array(
	'Semanatrabajos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Agregar Dias Laborales', 'url'=>array('create', 'id_usr'=>$usuario->id)),	
);
?>

<h4>Usuario: </h4>
<h4>Nombre: <?php echo $usuario{'nombre'}; ?></h4>
<h4>Apellido: <?php echo $usuario{'apellido'}; ?></h4>

<?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'sucursal-grid',
            'dataProvider' => $DataProviderSemanas,            
            'columns' => array(                                                       
                array(
                    'name' => 'nrosemana',
                    'header'=>'Semana',                    
                ),                                           
                array(
                    'name' => 'lun',
                    'header'=>'Lun',  
                    'value'=>'$data->lun == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'mar',
                    'header'=>'Mar',                    
                    'value'=>'$data->mar == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'mie',
                    'header'=>'Mie',    
                    'value'=>'$data->mie == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'jue',
                    'header'=>'Jue',    
                    'value'=>'$data->jue == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'vie',
                    'header'=>'Vie',    
                    'value'=>'$data->vie == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'sab',
                    'header'=>'Sab',    
                    'value'=>'$data->sab == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'dom',
                    'header'=>'Dom',    
                    'value'=>'$data->dom == 1 ? "Si" : " "',
                ),                                       
                array(
                    'name' => 'hsdesde',
                    'header'=>'Desde',    
                  
                ),
                array(
                    'name' => 'hshasta',
                    'header'=>'Hasta',    
                  
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{update} {delete}', // botones a mostrar
                    'buttons' => array(                        
                        'delete' => array
                        (
                            'label'=>'Eliminar',
                            'icon'=>'glyphicon glyphicon-trash',

                            'click' => 'function(){return confirm("Desea eliminar la seamana?");}',
                            'url'=>'Yii::app()->createUrl("semanatrabajo/eliminar/id/$data->id/id_usr/'.$semanatrabajo->id_usr.'")',
                                                                              
                            
                        ),                        
                        'update' => array(
                            'label' => 'Modificar Dias', 
                            'url'=>'Yii::app()->createUrl("semanatrabajo/update/id/$data->id/id_usr/'.$semanatrabajo->id_usr.'")',
                            
                        ),
                    ),
                    'htmlOptions'=>array('width'=>'4O%'),
                    ),
            ),
              
        ));
    ?> 