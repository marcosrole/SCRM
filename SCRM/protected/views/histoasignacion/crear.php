


<h1>Asignar Dispositivo</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
    <h3>Empresas:</h3>
    
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataProviderEmpresas,
                    'filter' => $empresa,
                    'columns' => array(                        
                        array(
                            'name' => 'cuit',
                            'header'=>'CUIT',
                                                        
                        ),
                        array(
                            'name' => 'razonsocial',
                            'header'=>'Razon Social'
                        ),
                         array(
                            'id' => 'selectedIds1',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                        ),                        
                    ),
                    
                ));
                
            ?>
        <?php echo $form->error($histasignacion,'cuit'); ?>
        <?php echo $form->error($histasignacion,'razonsocial'); ?>
        
    </div>
    
    
    <h3>Dispositivos:</h3>
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataProviderDispositivo,
                    'filter' => $dispositivo,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'header'=>'ID',                            
                        ),
                        array(
                            'name' => 'mac',
                            'header'=>'MAC',                            
                        ),
                        array(
                            'name' => 'funciona',
                            'header'=>'Funciona',
                            'type'=>'boolean'
                            
                        ),
                        array(
                            'id' => 'selectedIds2',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                        ),
                    ),
                ));
            ?>
        <?php echo $form->error($histasignacion,'id_dis'); ?>
        
    </div>

    <h3>Coordenadas Geograficas</h3>
        <div class="campo">
		<?php echo $form->textFieldGroup(
			$histasignacion,
			'coord_lat',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histasignacion,'coord_lat'); ?>
	</div>
    
        <div class="campo">
		<?php echo $form->textFieldGroup(
			$histasignacion,
			'coord_lon',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histasignacion,'coord_lon'); ?>
	</div>
    
        <div class="campo">
            <?php echo $form->datePickerGroup(
                   $histasignacion,
                   'fecha_alta',
                   array(
                           'widgetOptions' => array(
                                   'options' => array(
                                           'language' => 'es',
                                   ),
                           ),
                           'wrapperHtmlOptions' => array(
                                   'class' => 'col-sm-5',
                           ),
                           'hint' => ' ',
                           'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
                   )
           ); ?>
                <?php echo $form->error($histasignacion,'fecha_alta'); ?>
        </div>
    
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Asignar',
                    'context' => 'success',
                    'buttonType'=>'submit', 
                    )); 
        ?>        
    </div>

    <?php $this->endWidget(); ?>
</div>

