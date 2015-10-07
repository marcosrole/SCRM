<?php
/* @var $this PermisosusuarioController */
/* @var $data Permisosusuario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usr')); ?>:</b>
	<?php echo CHtml::encode($data->id_usr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_per')); ?>:</b>
	<?php echo CHtml::encode($data->id_per); ?>
	<br />


</div>