<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'permisosusuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_usr'); ?>
		<?php echo $form->textField($model,'id_usr'); ?>
		<?php echo $form->error($model,'id_usr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_per'); ?>
		<?php echo $form->textField($model,'id_per'); ?>
		<?php echo $form->error($model,'id_per'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->