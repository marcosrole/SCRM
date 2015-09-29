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
            <?php echo $form->labelEx($empresa,'cuit'); ?>
            <?php
                echo $form->textField($empresa, 'cuit', 
                        array(
                            
                            'class' => 'form-control', 
                            'value'=>$empresa{'cuit'}));                
            ?>
            <?php echo $form->labelEx($empresa,'razonsocial'); ?>
            <?php
                echo $form->textField($empresa, 'razonsocial', 
                        array(
                            'class' => 'form-control', 
                            'value'=>$empresa{'razonsocial'}));                
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
