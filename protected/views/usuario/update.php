<?php
/* @var $this CalibracionController */
/* @var $model Calibracion */


$this->menu=array(
	array('label'=>'Listar Calibraciones', 'url'=>array('list')),
	array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
);
?>

<h1>Actualizar valores de aceptación <?php  ?></h1>

<h3>Datos originales: <?php  ?></h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$usuario,
	'attributes'=>array(
		'id',
		'name',
		'pass',
		'nivel',		
	),
)); ?>

<div class="form">
    <br>
<?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($usuario); ?>
        	
	<div class="row">
            <?php echo $form->textFieldGroup($usuario,'pass',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
	</div>


	<div class="row buttons">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Actualizar', 'context' => 'success','buttonType'=>'submit',));         ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->