
<div class="label_original">
        <h2>Empresa: <?php echo $empresa_original ?> </h2>            
    </div>
    
<?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
    <div class="dato_nuevo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresa-grid-list',
                    'dataProvider' => $dataProviderSucursal,      
                    
                    'columns' => array(                        
                        array(
                            'name' => 'nombre',
                            'header'=>'Sucursal',                                                        
                        ),
                        array(
                            'name' => 'empresa',
                            'header'=>'Empresa'
                        ),
                        array(
                            'name' => 'direccion',
                            'header'=>'Direccion'
                        ),
                        array(
                            'name' => 'localidad',
                            'header'=>'Localidad'
                        ),
                         array(
                            'id' => 'selectedEmpresa',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                        ),                        
                    ),
                    
                ));                
            ?>   
    </div>
    <div class="dato_nuevo">
        <?php echo $form->textAreaGroup(
			$histoasignacion,
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
    </div>
    
       
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Actualizar',
                    'context' => 'success',                    
                    'buttonType'=>'submit', 
                    
                    )); 
        ?>        
    </div>
    <?php $this->endWidget(); ?>    