<?php

$this->menu=array(
	array('label'=>'Listar Usuarios', 'url'=>array('index')),
	
);
?>

<h1>Crear Usuario</h1>

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
                            
			)
		); ?>           
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
	</div>
    
    <div class="boton">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

