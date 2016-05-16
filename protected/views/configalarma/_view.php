<?php
/* @var $this ConfigalarmaController */
/* @var $data Configalarma */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('segCont')); ?>:</b>
	<?php echo CHtml::encode($data->segCont); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('porcCont')); ?>:</b>
	<?php echo CHtml::encode($data->porcCont); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('pico')); ?>:</b>
	<?php echo CHtml::encode($data->segInter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('segInter')); ?>:</b>
	<?php echo CHtml::encode($data->segInter); ?>
	<br />
        
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('cantPico')); ?>:</b>
	<?php echo CHtml::encode($data->cantInter); ?>
	<br />


</div>