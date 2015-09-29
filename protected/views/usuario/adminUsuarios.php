<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
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
    
    <body>
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
        <div class="form">    
            <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>            
                <div class="campo">
                    <?php 
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => 'dispositivo-grid-list',
                                'dataProvider' => $usuario->search(),
                                'filter' => $usuario,
                                'columns' => array(                        
                                    array(
                                        'name' => 'name',
                                        'header'=>'Nombre',                                                                                               
                                    ),
                                    array(
                                        'name' => 'pass',
                                        'header'=>'Contraseña',                                        
                                    ),                           
                                    array(
                                        'class' => 'booster.widgets.TbButtonColumn',
                                        'template'=> '{delete}{edit}',
                                        'buttons'=>array
                                            (
                                                'delete' => array
                                                (
                                                    'label'=>'Eliminar',
                                                    'icon'=>'glyphicon glyphicon-trash',
                                                    'label' => 'Eliminar',                             
                                                    'click' => 'function(){return confirm("Desea eliminar el Usuario?");}',
                                                    'url'=> 'Yii::app()->createUrl("/Usuario/Eliminar?name=$data->name")',                                                    
                                                    'options'=>array(
                                                        'class'=>'btn btn-small',
                                                    ),
                                                ),
                                                'edit' => array(
                                                        'label'=>'Modificar',
                                                        'icon'=>'glyphicon glyphicon-pencil',
                                                        'url'=>'Yii::app()->createUrl("usuario/modificar", array("name"=>$data->name,"pass"=>$data->pass))',
                                                        'options'=>array(
                                                            'class'=>'btn btn-small',
                                                            'ajax'=>array(
                                                                'type'=>'POST',
                                                                'url'=>"js:$(this).attr('href')",
                                                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                                                            ),
                                                        ),
                                                    ), 
                                        ),             
                                         'htmlOptions'=>array('style'=>'width: 120px'),
                                    ),              
                                ),                    
                            ));                
                        ?> 
                </div>    
            <?php $this->endWidget(); ?>
            
           
            <!-- View Popup  -->
            <?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'viewModal')); ?>
                <!-- Popup Header -->
                <div class="modal-header">
                <div class="modal-header" style="padding:10px 10px;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
                </div>
                </div>
                <!-- Popup Content -->
                <div class="modal-body">
                <p>  <?php  ?></p>
                </div>
                <!-- Popup Footer -->
                <div class="modal-footer">
                <!-- close button -->
                <!-- close button ends-->
                </div>
            <?php $this->endWidget(); ?>
            <!-- View Popup ends -->
    </body>
</html>
