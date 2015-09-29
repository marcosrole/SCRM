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
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array('id' => 'verticalForm',)); ?>
            <?php echo $form->labelEx($sucursal,'id'); ?>
            <?php
                echo $form->textField($sucursal, 'id', 
                        array(
                            'class' => 'form-control', 
                            'value'=>$sucursal{'id'}));                
            ?>
            
            <?php echo $form->labelEx($sucursal,'nombre'); ?>
            <?php echo $form->textField($sucursal, 'nombre', 
                        array(
                            'class' => 'form-control', 
                            'value'=>$sucursal{'nombre'}));                
            ?>
                        
            <div class="boton">
                <?php $this->widget('booster.widgets.TbButton', 
                        array(                            
                            'label' => 'Actualizar',
                            'context' => 'success',                    
                            'buttonType'=>'submit', 
                            )); 
                ?>        
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>

        
    </body>
</html>
