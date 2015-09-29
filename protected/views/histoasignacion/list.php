<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>            
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $histoasignacion->search(),
                    'filter' => $histoasignacion,
                    'columns' => array(                        
                        array(
                            'name' => 'id_dis',
                            'header'=>'Dispositivo',                                                       
                        ),                        
                        array(
                            'name' => 'fechaAlta',
                            'header'=>'Fecha de Alta'
                        ),
                        array(
                            'name' => 'fechaModif',
                            'header'=>'Fecha de Modificacion'
                        ),
                        array(
                            'name' => 'fechaBaja',
                            'header'=>'Fecha de Baja'
                        ),
                        array(
                            'name' => 'observacion',
                            'header'=>'Obervaciones'
                        ),                                                 
                    ),                    
                ));                
            ?> 
    </div>    
        <?php $this->endWidget(); ?>
        
    </div>
