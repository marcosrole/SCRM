<?php
/* @var $this SucursalController */
/* @var $data Sucursal */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuit_emp')); ?>:</b>
	<?php echo CHtml::encode($data->cuit_emp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dir')); ?>:</b>
	<?php echo CHtml::encode($data->id_dir); ?>
	<br />


</div>