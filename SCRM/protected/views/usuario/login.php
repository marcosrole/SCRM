<h1>Login</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
        <div class="row">            
            <?php echo $form->textFieldGroup(
			$model,
			'name',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
                            'width' => '40',
                            
			)
		); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>   

        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'pass',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>
    
    <div class="boton">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Entrar' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
