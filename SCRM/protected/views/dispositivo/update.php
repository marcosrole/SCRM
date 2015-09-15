LA IDEA ES MOSTRAR POR DEFECTO EN EL CONTENDIO DE CADA CAMPO EL DISPOSITIVO A MODIFICAR.

<h1>Actualizar datos</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
        
        <h5>ID: <?php echo $id_dis ?> </h5>
        <div class="row">            
            <?php echo $form->textFieldGroup(
			$dispositivo,
			'mac',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
                            'width' => '40',
                            'value' => 'assasa',
                            
			)
		); ?>
            <?php echo $form->error($dispositivo,'mac'); ?>
        </div>   
    

        <div class="row">
		<?php echo $form->textFieldGroup(
			$dispositivo,
			'modelo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				), 
                            'value' => 'assasa',
			)
		); ?>
		<?php echo $form->error($dispositivo,'modelo'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->textFieldGroup(
			$dispositivo,
			'version',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($dispositivo,'version'); ?>
	</div>
        
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Actualizar',
                    'context' => 'success',
                    'buttonType'=>'submit', 
                    )); 
        ?>        
    </div>

    <?php $this->endWidget(); ?>
</div>
