
<style>
a#quitar_semana2 {
    float: right;
}
.boton {
    margin-top: 5%;
}
</style>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('semana2', '
    $(function() {
    $("#ver_semana2").click(function() {      
      $("#semana2").show();
      $("formulario").scrollTop(1000);      
    });
    $("#ver_semana3").click(function() {      
      $("#semana3").show();
    });
    $("#ver_semana4").click(function() {      
      $("#semana4").show();
    });
    
    $("#quitar_semana2").click(function() {      
      $("#semana2").hide();
    });
    $("#quitar_semana3").click(function() {      
      $("#semana3").hide();
    });
    $("#quitar_semana4").click(function() {      
      $("#semana4").hide();
    });
  });
');

?>
<?php
/* @var $this SemanatrabajoController */
/* @var $model Semanatrabajo */

$this->breadcrumbs=array(
	'Semanatrabajos'=>array('index'),
	'Create',
);

$this->menu=array(	
        array('label'=>'Ver dias laborales del Usuario', 'url'=>array('view', 'id_usr'=>$datos_usuario{'id'})),
	
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
                'error' => array('closeText' => false),                
            ),
        ));
        ?>



<h4><strong>Usuario seleccionado: </strong></h4>
<?php
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos_usuario,
        'attributes' => array(
            array('name' => 'nombre', 'label' => 'Apellido y Nombre'),
            array('name' => 'zona', 'label' => 'Zona'),
        ),
        )
    );
?>
<h4><strong>Dias Laborales:</strong></h4>
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
                    'value'=>'$data["lun"] == 1 ? "Si" : " " ',
                ),                       
                array(
                    'name' => 'mar',
                    'header'=>'Mar',                    
                    'value'=>'$data["mar"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'mie',
                    'header'=>'Mie',    
                    'value'=>'$data["mie"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'jue',
                    'header'=>'Jue',    
                    'value'=>'$data["jue"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'vie',
                    'header'=>'Vie',    
                    'value'=>'$data["vie"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'sab',
                    'header'=>'Sab',    
                    'value'=>'$data["sab"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'dom',
                    'header'=>'Dom',    
                    'value'=>'$data["dom"]== 1 ? "Si" : " "',
                ),                                       
                array(
                    'name' => 'hsdesde',
                    'header'=>'Desde',    
                  
                ),
                array(
                    'name' => 'hshasta',
                    'header'=>'Hasta',    
                  
                ),
               
            ),
              
        ));
    ?> 
        <!--<a class="linkAgregarSemana" id="ver_semana2" href="#">Agregar Semana</a>-->
                
        <!--<div id="semana2" style="display:none">-->
        <div id="semana2">
            <?php $this->renderPartial('_form', array('model'=>$model)); ?>        
        </div>
        

