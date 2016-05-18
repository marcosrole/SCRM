<style>
    form#verticalForm {
    display: inline-block;
}
</style>
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