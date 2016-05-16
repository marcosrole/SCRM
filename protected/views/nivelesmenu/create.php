<script>
$(function() {
    $("#btnAgregarNA").click(function(){
       $("#nivelesDisponibles").toggle() ;
    });  
    
    $("#selectNivelAcceso").select(function(){
       $("#nivelesDisponibles").toggle() ;
    });  
    
    
    
});
</script>


<?php

/* @var $this NivelesmenuController */
/* @var $model Nivelesmenu */

$this->breadcrumbs=array(
	'Nivelesmenus'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Configurar Menues', 'url'=>array('admin')),
	array('label'=>'Listar usuarios', 'url'=>array('usuario/index')),
);
?>
<div id="text"></div>
<div class="form">    
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
    
                <h1>Configurar niveles de acceso</h1>

                <?php 
                        $this->widget(
                       'booster.widgets.TbDetailView',
                          array(
                           'data' => array(
                              //'id' =>array('view', 'id'=>$model->ID),
                              'usuario' => $usuario->name,
                              'nombre' => $persona->nombre,
                              'apellido' => $persona->apellido,
                              ),
                           'attributes' => array(
                               array('name' => 'usuario', 'label' => 'Usuario'),
                               array('name' => 'nombre', 'label' => 'Nombre'),                 
                               array('name' => 'apellido', 'label' => 'Apellido'),
                           ),
                           )
                       );
                  ?>
            <?php $this->endWidget(); ?>
            
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
                <?php $this->widget(
                        'booster.widgets.TbButton',
                        array(
                            'id' => 'btnAgregarNA',
                            'label' => 'Agregar nivel de acceso',
                            'context' => 'info',
                        )
                );
                
                ?>
            
                <div id="nivelesDisponibles" style="display: none" >
                    <!-- TODOS LOS NIVELES DE ACCESO -->
                    <?php 
                        $this->renderPartial('_nivelesAcceso', array('ListNivAccDispo'=>$ListNivAccDispo, ));                         
                    ?>
                </div>
                
                <div id="niveles"> 
                    <!--NIVELES DE ACCESO DEL USUARIO -->
                   

                    <?php 
                    $this->widget('booster.widgets.TbGridView', array(
                        'id' => 'dispositivo-grid-list',
                        'dataProvider' => $DataProviderNADispo,
                        'columns' => array( 
                        array(
                            'name' => 'NivelAcceso',
                            'header'=>'Nombre'
                        ),     
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                           // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{eliminar}', // botones a mostrar
                            'buttons' => array(
//                                'add' => array(
//                                    'label' => 'Añadir Menu',
//                                    'icon'=>'glyphicon glyphicon-plus', 
//                                    'url'=> 'Yii::app()->createUrl("nivelesmenu/update?id=$data->id")'
//                                ),                                                        
                                'eliminar' => array
                                (
                                    'label'=>'Eliminar',
                                    'icon'=>'glyphicon glyphicon-trash',

                                    'click' => 'function(){return confirm("Desea eliminar el nivel de Acceso?");}',
                                    'url'=> 'Yii::app()->createUrl("nivelesmenu/Eliminarr", array("id_UsrNivAcc"=> ' . '$data["id"])) ',
                                    
                                ),
                            ),

                        ))));
                    ?> 
                </div>
        <?php $this->endWidget(); ?>
</div>

