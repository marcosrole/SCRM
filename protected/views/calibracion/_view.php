<?php
/* @var $this CalibracionController */
/* @var $data Calibracion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_permitido')); ?>:</b>
	<?php echo CHtml::encode($data->db_permitido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dist_permitido')); ?>:</b>
	<?php echo CHtml::encode($data->dist_permitido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dis')); ?>:</b>
	<?php echo CHtml::encode($data->id_dis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_suc')); ?>:</b>
	<?php echo CHtml::encode($data->id_suc); ?>
	<br />


</div>