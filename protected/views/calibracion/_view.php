<?php
$this->widget('booster.widgets.TbAlert', array(
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array(// configurations per alert type
        // success, info, warning, error or danger
        'success' => array('closeText' => '&times;'),
        'info', // you don't need to specify full config
        'warning' => array('closeText' => false),
        'error' => array('closeText' => false),
    ),
));
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