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
                        
                    ),                    
                ));                
            ?> 
    </div>    
 <?php $this->endWidget(); ?>
</div>
