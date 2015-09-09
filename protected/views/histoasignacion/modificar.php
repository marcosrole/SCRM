<head>  
  <style>
  .modal-header, h4, .close {
      background-color: #19A3FF;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #19A3FF;
  }
  </style>
</head>


<script>
$(document).ready(function(){
    
    $("#nada").click(function(){
        alert('choto');
    });
    
    $("#miboton").click(function(){
        $("#myModal").modal();
    });

});
</script>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
        </div>
          
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form">
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-lock"></span> Rason Social</label>
              <input type="text" class="form-control" id="cuit_emp" placeholder="Ingrese Razon Social">
            </div>
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-bullhorn"></span> Dispositivo</label>
              <input type="text" class="form-control" id="id_dis" placeholder="Dispositivo...">
            </div>
            <div class="form-group">
              <label for=""><span class="glyphicon glyphicon-exclamation-sign"></span> Observaciones</label>
              <input type="text" class="form-control" id="observacion" placeholder="Observaciones (Opcional)">
            </div>
            
              <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Modificar</button>
          </form>
        </div>
          
        <div class="modal-footer">
         <!-- <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
          <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
        </div>-->
      </div>
      
    </div>
  </div> 
</div>
  
  

  
  <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', 
                    array(
                        'label' => 'Boton para probar Model',
                        'context' => 'success', 
                        'id'=> 'miboton',                        
                        )); 
            ?>        
        </div>

<h1>Modificaciones de Asignacion</h1>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'parmdialog',
    'options' => array(
        'title' => 'Update record',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
    ),
));

echo '<iframe id="parm-frame" width="100%" height="100%"></iframe>';

$this->endWidget('zii.widgets.jui.CJuiDialog');?>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
            
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $histoasignacion->search(),
                    'filter' => $histoasignacion,
                    'columns' => array(                        
                        array(
                            'name' => 'id_dis',
                            'header'=>'Dispositivo',                                                       
                        ),
                        array(
                            'name' => 'razonsocial_emp',
                            'header'=>'Razon Social'
                        ),
                        array(
                            'name' => 'fecha_alta',
                            'header'=>'Fecha de Alta'
                        ),
                        array(
                            'name' => 'fecha_modif',
                            'header'=>'Fecha de Modificacion'
                        ),
                        array(
                            'name' => 'observacion',
                            'header'=>'Obervaciones'
                        ),
                         array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{delete} {update}', // botones a mostrar
                            'buttons' => array(
                                "delete" => array(
                                    'label' => 'Eliminar',                             
                                    'click' => 'function(){return confirm("Desea eliminar todos los registro del dispositivo?");}',
                                    'url'=> 'Yii::app()->createUrl("/Dispositivo/Eliminar?id=$data->id_dis")'
                                ),
                                
                                    'update' => array(
                                        'label' => 'Updatse record',
                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodal",array("id_dis"=>"$data->id_dis","razonsocial"=>"$data->razonsocial_emp"))',
                                        //'url' => 'Yii::app()->createUrl("actualizar", array("id"=>$data->id_dis))',
                                       // 'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
                                    ),
                                
                            ),
                        ),                        
                    ),                    
                ));                
            ?> 
    </div>
    
    
        <?php $this->endWidget(); ?>
        
    </div>

    

