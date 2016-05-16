<style>
    form#verticalForm {
    display: inline-block;
}
</style>
<?php
/* @var $this CalibracionController */
/* @var $model Calibracion */
/* @var $form CActiveForm */
?>

<div class="form">
    <br>
<?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($calibracion); ?>
        
	<div class="row" style="display:none;">
            
	</div>
        
	<div class="row">
            <?php echo $form->textFieldGroup($calibracion,'db_permitido',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>		
	</div>

	<div class="row">
            <?php echo $form->textFieldGroup($calibracion,'dist_permitido',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
	</div>


	<div class="row buttons">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Cargar', 'context' => 'success','buttonType'=>'submit',));         ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->