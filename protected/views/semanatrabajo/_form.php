<style>
    label.checkbox {
    margin-left: 6%;
    margin-top: -1%;
}
span#Semanatrabajo_dias {
    display: -webkit-inline-box;
}
.semana {
    width: 20%;
}

.form {
    margin-top: 5%;
}
a.linkQuitarSemana {
    float: right;
}
.hora {
    display: -webkit-box;
}
</style>
<div class="form">

  
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
            'id' => 'UsuarioForm',
            'htmlOptions' => array('class' => 'well'), )); ?>
                
            <div class="semana">
                <?php echo $form->dropDownListGroup($model, 'nrosemana', array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'widgetOptions' => array(
                    'data' => array('1','2','3','4'),
                'htmlOptions' =>  array(),)));?>
            </div>

            <div class="dias">
                <?php echo $form->checkboxListGroup(
                                $model,
                                'dias',
                                array(
                                        'widgetOptions' => array(
                                                'data' => array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')
                                        ),
                                        'hint' => '<strong>Note:</strong> Seleccione los dias.'
                                )
                        ); ?>
            </div>
            <div class="hora">
                <div class="hsdesde">
                    
                    
                        <?php echo $form->dropDownListGroup($model, 'hsdesde', array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'widgetOptions' => array(
                            'data' => array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'),
                        'htmlOptions' =>  array(),)));?>
                    

                <div class="hshasta">
                    
                        <?php echo $form->dropDownListGroup($model, 'hshasta', array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'widgetOptions' => array(
                            'data' => array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'),
                        'htmlOptions' =>  array(),)));?>
                    
                </div>
                </div>     
            </div> 
    
    
        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Cargar', 'context' => 'success','buttonType' => 'submit',));?>
        </div>
    
    
    
    
                
                
    <?php $this->endWidget(); ?>        
</div>

