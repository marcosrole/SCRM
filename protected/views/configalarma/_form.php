<style>
    .row1 {
    display: -webkit-box;
}
.row2 {
    display: -webkit-box;
}
.segCont {
    margin-left: 5%;
}
.cantInter {
    margin-left: 5%;
}
.porcCont {
    margin-left: 1%;
}
.segInter {
    margin-left: 1%;
}
.pico {
    width: 15%;
    margin-left: 1%;
}
.cantPico {
    margin-left: 1%;
}
</style>
<?php
/* @var $this ConfigalarmaController */
/* @var $model Configalarma */
/* @var $form CActiveForm */
?>



<div class="form">    
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row1">
            <h4>Ruidos continuos: </h4>
            <div class="segCont">
                <?php echo $form->textFieldGroup($model, 'segCont', array('hint' => 'tiempo de medición (seg.)','style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
            <div class="porcCont">
                <?php echo $form->textFieldGroup($model, 'porcCont', array('hint' => '% de aceptación', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
        </div>
        
        <div class="row2">
            <h4>Ruidos Intermitentes: </h4>
            <div class="pico">
                <?php echo $form->textFieldGroup($model, 'pico', array('hint' => 'cantidad de registros para un pico', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div>
            <div class="cantPico">
                <?php echo $form->textFieldGroup($model, 'cantPico', array('hint' => 'cantidad de picos', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div>
            <div class="segInter">
                <?php echo $form->textFieldGroup($model, 'segInter', array('hint' => 'tiempo de medicóon (seg.)', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
             
        </div>
        
        
	 <div class="boton">
                    <?php $this->widget('booster.widgets.TbButton', 
                             array(
                                 'label' => 'Guardar',
                                 'context' => 'success',
                                 'buttonType'=>'submit', 
                                 )); 
                     ?>
                 </div>

  <?php $this->endWidget(); ?>

</div><!-- form -->