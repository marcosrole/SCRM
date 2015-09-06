<?php
/* @var $this DetalleDispoController */
/* @var $model DetalleDispo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalle-dispo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_dispo'); ?>
		<?php echo $form->textField($model,'id_dispo',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'id_dispo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_db'); ?>
		<?php echo $form->textField($model,'s_db'); ?>
		<?php echo $form->error($model,'s_db'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_dist'); ?>
		<?php echo $form->textField($model,'s_dist'); ?>
		<?php echo $form->error($model,'s_dist'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hs'); ?>
		<?php echo $form->textField($model,'hs'); ?>
		<?php echo $form->error($model,'hs'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->