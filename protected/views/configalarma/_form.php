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
.segInt {
    width: 15%;
    margin-left: 1%;
}
.porcInt {
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
                <?php echo $form->textFieldGroup($model, 'segCont', array('hint' => 'definicion de ruido continuo (seg.)','style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
            <div class="porcCont">
                <?php echo $form->textFieldGroup($model, 'porcCont', array('hint' => '% de aceptación', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
        </div>
        
        <div class="row2">
            <h4>Ruidos Intermitentes: </h4>
            <div class="segInt">
                <?php  echo $form->textFieldGroup($model, 'segInt', array('hint' => 'definicion ruido intermedio', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div>
            <div class="porcInt">
                <?php  echo $form->textFieldGroup($model, 'porcInt', array('hint' => '% de aceptacion', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div>
             
        </div>
        
        <div class="row2">
            <h4>Dispositivo obstruido: </h4>
            <div class="segDis">
                <?php  echo $form->textFieldGroup($model, 'segDis', array('hint' => 'distancia permitida (seg.)', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div>
            <div class="porcDis">
                <?php  echo $form->textFieldGroup($model, 'porcDis', array('hint' => '% de aceptacion', 'style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
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