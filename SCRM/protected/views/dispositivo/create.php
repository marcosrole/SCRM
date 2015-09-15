<?php
/* @var $this DetalleDispoController */
/* @var $model DetalleDispo */

$this->breadcrumbs=array(
	'Detalle Dispos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cargar Detalles', 'url'=>array('DetalleDispo/create')),
	array('label'=>'Administrar Dispositivos', 'url'=>array('Dispositivo/admin')),
);
?>

<h1>Nuevo Dispositivo</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
        <div class="row">            
            <?php echo $form->textFieldGroup(
			$model,
			'mac',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
                            'width' => '40',
                            
			)
		); ?>
            <?php echo $form->error($model,'mac'); ?>
        </div>   
    

        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'modelo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'modelo'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'version',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>
        
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Cargar',
                    'context' => 'success',
                    'buttonType'=>'submit', 
                    )); 
        ?>        
    </div>

    <?php $this->endWidget(); ?>
</div>
