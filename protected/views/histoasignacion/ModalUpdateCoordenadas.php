
<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
    <div class="dato_nuevo">
        <div class="campo">
		<?php echo $form->textFieldGroup(
			$histoAsif,
			'coordLat',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histoAsif,'coordLat'); ?>
	</div>
    
        <div class="campo">
		<?php echo $form->textFieldGroup(
			$histoAsif,
			'coordLon',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histoAsif,'coordLon'); ?>
    </div>
    
       
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Actualizar',
                    'context' => 'success',                    
                    'buttonType'=>'submit', 
                    'htmlOptions' => array(
                            'name'=>'ActionButton',
                            'confirm' => 'Desea realizar los cambios?',
                    ),
                    )); 
        ?>        
    </div>
    <?php $this->endWidget(); ?>    
</div>