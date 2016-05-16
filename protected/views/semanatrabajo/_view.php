<?php
/* @var $this SemanatrabajoController */
/* @var $data Semanatrabajo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nrosemana')); ?>:</b>
	<?php echo CHtml::encode($data->nrosemana); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lun')); ?>:</b>
	<?php echo CHtml::encode($data->lun); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mar')); ?>:</b>
	<?php echo CHtml::encode($data->mar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mir')); ?>:</b>
	<?php echo CHtml::encode($data->mir); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jue')); ?>:</b>
	<?php echo CHtml::encode($data->jue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vie')); ?>:</b>
	<?php echo CHtml::encode($data->vie); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sab')); ?>:</b>
	<?php echo CHtml::encode($data->sab); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dom')); ?>:</b>
	<?php echo CHtml::encode($data->dom); ?>
	<br />

	*/ ?>

</div>