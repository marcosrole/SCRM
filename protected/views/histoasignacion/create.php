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

<?php
$this->menu=array(
	array('label'=>'Listar Asignaciones', 'url'=>array('list')),
	array('label'=>'Administrar Empresas', 'url'=>array('update')),
        array('label'=>'Crear Sucursal', 'url'=>array('sucursal/create')),
);
?>



<div class="form">    
    <h1>Asignar Dispositivo</h1>
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
            
    
    <h3>Sucursales disponibles:</h3>
    <p>Seleccione una sucursal a asignar un dispositivo.</p>
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresasAsociadas',
                    'dataProvider' => $DataProviderSucursales,    
                    'summaryText'=>'Página {page}-{pages} de {count} resultados.',
                    'columns' => array(                        
                        array(
                                'name' => 'nombre',
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
                                'name' => 'zona',
                                'header'=>'Zona',                                    
                            ),                            
                         array(
                            'header' => "",
                            'id' => 'selectSucursal',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                        ),                        
                    ),
                    
                ));
                
            ?>       
    </div>
    
        <?php echo $form->error($histasignacion,'id_suc'); ?>
    
    
    <h3>Dispositivos disponibles:</h3>
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataProviderDispositivo,
                    'summaryText'=>'Página {page}-{pages} de {count} resultados.',
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
                            'header' => "",
                            'id' => 'selectDispositivo',
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
			'coordLat',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histasignacion,'coordLat'); ?>
	</div>
    
        <div class="campo">
		<?php echo $form->textFieldGroup(
			$histasignacion,
			'coordLon',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($histasignacion,'coordLon'); ?>
	</div>
    
        <div class="campo">
            <?php echo $form->datePickerGroup(
                   $histasignacion,
                   'fechaAlta',
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
                <?php echo $form->error($histasignacion,'fechaAlta'); ?>
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