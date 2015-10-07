<?php
/* @var $this AsignarpermisoController */
/* @var $model Asignarpermiso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asignarpermiso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
        
        
	 <?php echo $form->checkboxListGroup(
                $asignarpermiso,
                'id_per',
                array(
                        'widgetOptions' => array(
                                'data' => $array_permiso,
                                'disabled'=>'disabled',
                        ),
                        'hint' => '<strong>Note:</strong> Seleccione todos los permisos para el usuario.'
                )
        ); ?>

        <?php
        $form->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Asignar',
                'context' => 'success',
                 'buttonType'=>'submit',
            )
        );
        ?>

<?php $this->endWidget(); ?>

</div><!-- form -->