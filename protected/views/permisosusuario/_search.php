<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */
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
		<?php echo $form->label($model,'id_usr'); ?>
		<?php echo $form->textField($model,'id_usr'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_per'); ?>
		<?php echo $form->textField($model,'id_per'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->