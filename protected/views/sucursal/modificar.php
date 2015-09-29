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
        <?php $sucursal = new Sucursal(); ?>
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataProvieder,
                    'filter' => $sucursal,
                    'columns' => array(                        
                        array(
                            'name' => 'id',
                            'header'=>'ID',                                                       
                        ),
                        array(
                            'name' => 'nombre',
                            'header'=>'Nombre'
                        ),
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'template'=> '{edit}',
                            'buttons'=>array
                                (                                    
                                'edit' => array(
                                        'label'=>'Modificar',
                                        'icon'=>'glyphicon glyphicon-pencil',
                                        'url'=>'Yii::app()->createUrl("sucursal/update", array("id"=>$data->id))',
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
                             'htmlOptions'=>array('style'=>'width: 140px'),
                        ), 
                    ),                    
                ));                
            ?> 
    </div>    
 <?php $this->endWidget(); ?>
</div>

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
