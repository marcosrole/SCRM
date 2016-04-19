<?php
/* @var $this AccesodispositivoController */
/* @var $data Accesodispositivo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaUltimo')); ?>:</b>
	<?php echo CHtml::encode($data->fechaUltimo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hsUltimo')); ?>:</b>
	<?php echo CHtml::encode($data->hsUltimo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_detDis')); ?>:</b>
	<?php echo CHtml::encode($data->id_detDis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dis_detDis')); ?>:</b>
	<?php echo CHtml::encode($data->id_dis_detDis); ?>
	<br />


</div>