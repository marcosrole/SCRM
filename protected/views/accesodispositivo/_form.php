<?php
/* @var $this AccesodispositivoController */
/* @var $model Accesodispositivo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accesodispositivo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaUltimo'); ?>
		<?php echo $form->textField($model,'fechaUltimo'); ?>
		<?php echo $form->error($model,'fechaUltimo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hsUltimo'); ?>
		<?php echo $form->textField($model,'hsUltimo'); ?>
		<?php echo $form->error($model,'hsUltimo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_detDis'); ?>
		<?php echo $form->textField($model,'id_detDis'); ?>
		<?php echo $form->error($model,'id_detDis'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_dis_detDis'); ?>
		<?php echo $form->textField($model,'id_dis_detDis'); ?>
		<?php echo $form->error($model,'id_dis_detDis'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->