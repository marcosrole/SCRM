<?php
/* @var $this CalibracionController */
/* @var $model Calibracion */
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
		<?php echo $form->label($model,'db_permitido'); ?>
		<?php echo $form->textField($model,'db_permitido'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dist_permitido'); ?>
		<?php echo $form->textField($model,'dist_permitido'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_dis'); ?>
		<?php echo $form->textField($model,'id_dis'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_suc'); ?>
		<?php echo $form->textField($model,'id_suc'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->