<?php
/* @var $this DetalleDispoController */
/* @var $model DetalleDispo */

$this->breadcrumbs=array(
	'Detalle Dispos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DetalleDispo', 'url'=>array('index')),
	array('label'=>'Manage DetalleDispo', 'url'=>array('admin')),
);
?>

http://localhost/SCRM/DetalleDispo/create/00:13:49:00:01:02/99/0/2015-03-22/2:00:00

<h1>Crear Registro</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    <div class="row">
     
		<?php echo $form->dropDownListGroup(
			$model,
			'id_dis',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => $array_dispo,
					'htmlOptions' => array(),
				)
			)
		); ?>
                <?php echo $form->error($model,'id_dis'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'db',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'db'); ?>
	</div>

	<div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'distancia',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',                                        
				),				
			)
		); ?>
		<?php echo $form->error($model,'distancia'); ?>
	</div>

	<div class="row">		
		<?php echo $form->datePickerGroup(
			$model,
			'fecha',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
					),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-3',
				),
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
            
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->timePickerGroup(
			$model,
			'hs',
			array(
				'widgetOptions' => array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-sm-3'
					),
				),
							)
		); ?>
		<?php echo $form->error($model,'hs'); ?>
	</div>
    
    <div class="boton">
        <?php echo CHtml::submitButton('Guardar'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

