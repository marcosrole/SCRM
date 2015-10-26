<?php
/* @var $this SucursalController */
/* @var $model Sucursal */
/* @var $form CActiveForm */
?>
<div class="wide form">   
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm','type' => 'horizontal',)); ?>            
        <div class="row">            
            <?php echo $form->textFieldGroup($sucursal,'nombre',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'width' => '40',)); ?>
            <?php echo $form->error($sucursal,'nombre'); ?>
        </div>   
        <div class="row">            
            <?php echo $form->textFieldGroup($sucursal,'cuit_emp',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'width' => '40',)); ?>
            <?php echo $form->error($sucursal,'cuit_emp'); ?>
        </div>
        <div class="row">            
            <?php echo $form->textFieldGroup($empresa,'razonsocial',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'width' => '40',)); ?>
            <?php echo $form->error($empresa,'razonsocial'); ?>
        </div>    
        
        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', 
                    array(
                        'label' => 'Buscar',
                        'context' => 'success',
                        'buttonType'=>'submit', 
                        )); 
            ?>        
        </div>

    <?php $this->endWidget(); ?>
</div>


