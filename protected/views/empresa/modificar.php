<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
                                'dataProvider' => $empresa->search(),
                                'filter' => $empresa,
                                'columns' => array(                        
                                    array(
                                        'name' => 'cuit',
                                        'header'=>'CUIT',                                                                                               
                                    ),
                                    array(
                                        'name' => 'razonsocial',
                                        'header'=>'Razon Social',                                        
                                    ),                           
                                    array(
                                        'class' => 'booster.widgets.TbButtonColumn',
                                        'template'=> '{delete}{edit}{sucursal}',
                                        'buttons'=>array
                                            (
                                                'delete' => array
                                                (
                                                    'label'=>'Eliminar',
                                                    'icon'=>'glyphicon glyphicon-trash',
                                                                               
                                                    'click' => 'function(){return confirm("Desea eliminar todos los registros de la empresa?");}',
                                                    'url'=> 'Yii::app()->createUrl("empresa/delete?cuit=$data->cuit")',                                                    
                                                    'options'=>array(
                                                        'class'=>'btn btn-small',
                                                    ),
                                                ),
                                                'edit' => array(
                                                        'label'=>'Modificar',
                                                        'icon'=>'glyphicon glyphicon-pencil',
                                                        'url'=>'Yii::app()->createUrl("empresa/update", array("cuit"=>$data->cuit, "razonsocial"=>$data->razonsocial))',
                                                        'options'=>array(
                                                            'class'=>'btn btn-small',
                                                            'ajax'=>array(
                                                                'type'=>'POST',
                                                                'url'=>"js:$(this).attr('href')",
                                                                'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                                                            ),
                                                        ),
                                                    ), 
                                                'sucursal' => array(
                                                        'label'=>'Sucursal',
                                                        'icon'=>'glyphicon glyphicon-list-alt',
                                                        'url'=>'Yii::app()->createUrl("sucursal/modificar", array("cuit"=>$data->cuit))',                                                        
                                                    ), 
                                        ),             
                                         'htmlOptions'=>array('style'=>'width: 140px'),
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
            
            <!-- View Popup  -->
            <?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'ModalDelete')); ?>
                <!-- Popup Header -->
                <div class="modal-header">
                <div class="modal-header" style="padding:10px 10px;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4><span class="glyphicon glyphicon-pencil"></span> Eliminar</h4>
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
