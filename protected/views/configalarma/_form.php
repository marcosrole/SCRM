<style>
.row1 {
    display: -webkit-box;
    margin-left: 2%;
}
.row2 {
    display: -webkit-box;
    margin-left: 2%;
}
.segCont {
    margin-left: 2%;
}
.porcCont {
    margin-left: 2%;
}
.recibirAlaContinuo {
    margin-left: 2%;
}
.segInt {
    margin-left: 2%;
}
.porcInt {
    width: 18%;
    margin-left: 2%;
}
.recibirAlaIntermitente {
    margin-left: 2%;
}
.segDis {
    margin-left: 2%;
}
.porcDis {
    margin-left: 2%;
}
.recibirAlaDistancia {
    margin-left: 2%;
}
.segMuerto {
    margin-left: 2%;
}
.recibirAlaMuerto {
    margin-left: 2%;
}
.tolResponsable {
    margin-left: 2%;
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

    <p class="note">Los campos con <span class="required">*</span> son obligatorios. <strong>Todos los datos estan expresados en minutos (min)</strong></p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row1">
            <h4>Ruidos continuos: </h4>
            
            <div class="segCont">
                <?php echo $form->dropDownListGroup($model, 'segCont', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="porcCont">
                <?php echo $form->dropDownListGroup($model, 'porcCont', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $porcentajeAceptacion,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="porcCont">
                <?php echo $form->dropDownListGroup($model, 'recibirAlaContinuo', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
                
            </div> 
        </div>
        
        <div class="row2">
            <h4>Ruidos Intermitentes: </h4>
            <div class="segInt">
                <?php echo $form->dropDownListGroup($model, 'segInt', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="porcInt">
                <?php echo $form->dropDownListGroup($model, 'porcInt', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $porcentajeAceptacion,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="recibirAlaIntermitente">
                <?php echo $form->dropDownListGroup($model, 'recibirAlaIntermitente', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
                
            </div> 
        </div>
        
        <div class="row2">
            <h4>Dispositivo obstruido: </h4>
            <div class="segDis">
                <?php echo $form->dropDownListGroup($model, 'segDis', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="porcDis">
                <?php echo $form->dropDownListGroup($model, 'porcDis', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $porcentajeAceptacion,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="recibirAlaDistancia">
                <?php echo $form->dropDownListGroup($model, 'recibirAlaDistancia', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
             
        </div>
        
        <div class="row2">
            <h4>Dispositivo Muerto: </h4>
            <div class="segMuerto">
                <?php echo $form->dropDownListGroup($model, 'segMuerto', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
            <div class="recibirAlaMuerto">
                <?php echo $form->dropDownListGroup($model, 'recibirAlaMuerto', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
            </div> 
            
        </div>
        <div class="row2"> 
            <h4>Tiempo de espera para responsable: </h4>
            <div class="tolResponsable">
                <?php echo $form->dropDownListGroup($model, 'tolResponsable', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                                    'data' => $minutosDisponibles,
                                    'htmlOptions' => array(),)));?>
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