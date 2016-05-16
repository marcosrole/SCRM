<?php
/* @var $this SemanatrabajoController */
/* @var $model Semanatrabajo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nrosemana'); ?>
		<?php echo $form->textField($model,'nrosemana'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lun'); ?>
		<?php echo $form->textField($model,'lun'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mar'); ?>
		<?php echo $form->textField($model,'mar'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mir'); ?>
		<?php echo $form->textField($model,'mir'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jue'); ?>
		<?php echo $form->textField($model,'jue'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vie'); ?>
		<?php echo $form->textField($model,'vie'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sab'); ?>
		<?php echo $form->textField($model,'sab'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dom'); ?>
		<?php echo $form->textField($model,'dom'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->