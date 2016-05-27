<?php
/* @var $dataInspectores dataprovieder de Inspectores Disponibles */
/* @var $model Asignarinspector */
/* @var $form CActiveForm */
?>
<?php
        $this->widget('booster.widgets.TbAlert', array(
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array( // configurations per alert type
                // success, info, warning, error or danger
                'success' => array('closeText' => '&times;'),
                'info', // you don't need to specify full config
                'warning' => array('closeText' => false),
                'error' => array('closeText' => false),                
            ),
        ));
        
?>
<div class="form">    
    
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'AsignarInspector',
                'htmlOptions' => array('class' => 'well'), )); ?>
            
    
    <h3>Alarmas:</h3>
    
    <div class="alarma">
        <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderAlarmas,
            'columns' => array(                                                
                array(
                    'name' => 'alarma',
                    'header'=>'Alarma',        
                ),
                array(
                    'name' => 'sucursal',
                    'header'=>'Sucursal',                                                        
                ),
                array(
                    'name' => 'empresa',
                    'header'=>'Empresa',                                                        
                ),                    
                array(
                    'name' => 'direccion',
                    'header'=>'Direccion',                                                        
                ),
                array(
                    'name' => 'localidad',
                    'header'=>'Localidad',                                                        
                ),
                array(
                    'name' => 'fecha',
                    'header'=>'Fecha',                                                        
                ),
                array(
                    'name' => 'hs',
                    'header'=>'HS',                                                        
                ),
                array(
                    'header' => "",
                    'id' => 'selectAlarma',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                ), 
            ),

        ));
    ?>         
    </div>
    
    <h3>Inspectores Disponibles:</h3>
    
    <div class="inspectores">
        <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderInspector,
            'columns' => array(                                                
                array(
                    'name' => 'dni',
                    'header'=>'DNI',        
                ),
                array(
                    'name' => 'nombre',
                    'header'=>'Nombre y Apellido',                                                        
                ),
                array(
                    'name' => 'usuario',
                    'header'=>'Usuario',                                                        
                ),
                array(
                    'name' => 'sexo',
                    'header'=>'Sexo', 
                    'value'=>'$data["sexo"]== 0 ? "Hombre" : "Mujer"', 
                ),                    
                array(
                    'name' => 'zona',
                    'header'=>'Zona',                                                        
                ),
                
                array(
                    'header' => "",
                    'id' => 'selectInspector',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                ), 
            ),

        ));
    ?>         
    </div>
    
    
    <?php echo $form->textAreaGroup(
            $AasignarInspector,
            'observacion',
            array(
                    'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                            'htmlOptions' => array('rows' => 5),
                    )
            )
        ); ?>
    
    
    
    
    
    
    
    
    
    
    
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', array('label' => 'Asignar','context' => 'success','buttonType'=>'submit',)); ?>        
    </div>
    
    <?php $this->endWidget(); ?>
    
</div>
