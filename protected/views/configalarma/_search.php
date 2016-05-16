<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */
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
		<?php echo $form->label($model,'segCont'); ?>
		<?php echo $form->textField($model,'segCont'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'porcCont'); ?>
		<?php echo $form->textField($model,'porcCont'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'segInter'); ?>
		<?php echo $form->textField($model,'segInter'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cantInter'); ?>
		<?php echo $form->textField($model,'cantInter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->