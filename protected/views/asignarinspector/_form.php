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
            
    
    <h3>Inspectores Disponibles:</h3>
    
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresasAsociadas',
                    'dataProvider' => $dataInspectores,
                   // 'filter' => $dataInspectores,
                    'columns' => array(                                                
                        array(
                            'name' => 'dni',
                            'header'=>'DNI',        
                            
                            
                        ),
                        array(
                            'name' => 'nombre',
                            'header'=>'Appelido y Nombre',                                                        
                        ),
                        array(
                            'name' => 'sexo',                            
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
    
    <h3>Sucursales:</h3>
    
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresasAsociadas',
                    'dataProvider' => $dataSucursales,
                   // 'filter' => $dataInspectores,
                    'columns' => array(                                                
                        array(
                            'name' => 'nombre_suc',
                            'header'=>'Sucursal',                                    
                        ),
                        array(
                            'name' => 'nombre_emp',
                            'header'=>'Empresa',                                    
                        ),
                        array(
                            'name' => 'direccion',
                            'header'=>'Direccion',                                    
                        ),
                        array(
                            'name' => 'alarma',
                            'header'=>'Alarma',                                    
                        ),  
                        array(
                            'name' => 'hs',
                            'header'=>'Hora',                                    
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
    
    <p>
        
    </p>
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', array('label' => 'Asignar','context' => 'success','buttonType'=>'submit',)); ?>        
    </div>
    <?php $this->endWidget(); ?>
    
</div>
