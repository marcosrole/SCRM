<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'AsignarInspector',
                'htmlOptions' => array('class' => 'well'), )); ?>

<?php 
    $Nivelacceso = new Nivelacceso();
    $dataProvider = Nivelacceso::model()->search();
    $dataProvider->setData($ListNivAccDispo);
    
    $this->widget('booster.widgets.TbGridView', array(
        'id' => 'dispositivo-grid-list',
        'dataProvider' => $dataProvider,
         'columns' => array(                                                
                        array(
                            'name' => 'id',
                            'header'=>'#',                                    
                        ),
                        array(
                            'name' => 'nombre',
                            'header'=>'nombre',                                    
                        ),                        
                        array(
                            'header' => "",
                            'id' => 'selectNivelAcceso',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                        ),                        
                    ),
    ));
    ?>
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', array('label' => 'Asignar','context' => 'success','buttonType'=>'submit',)); ?>        
    </div>
    

<?php $this->endWidget(); ?>