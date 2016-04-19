<?php
/* @var $this AccesodispositivoController */
/* @var $model Accesodispositivo */
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
		<?php echo $form->label($model,'fechaUltimo'); ?>
		<?php echo $form->textField($model,'fechaUltimo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hsUltimo'); ?>
		<?php echo $form->textField($model,'hsUltimo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_detDis'); ?>
		<?php echo $form->textField($model,'id_detDis'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_dis_detDis'); ?>
		<?php echo $form->textField($model,'id_dis_detDis'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->