


<h1>Asignar Dispositivo</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
    <h3>Empresas:</h3>
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $empresa->search(),
                    'filter' => $empresa,
                    'columns' => array(                        
                        array(
                            'name' => 'cuit',
                            'header'=>'CUIT',
                            'sortable'=>'true',                            
                        ),
                        array(
                            'name' => 'razonsocial',
                            'header'=>'Razon Social'
                        ),
                        
                        /*array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '40'), //ancho de la columna
                            'template' => '{view}', // botones a mostrar
                            'buttons'=>array(
                                "view"=>array(
                                    'label'=>'Detalles',                    
                                    'url'=>'Yii::app()->createUrl("/DetalleDispo/ViewbyPk?id_dispo=$data->id_dispositivo")')),
                        ),*/
                    ),
                ));
            ?>
    </div>
    
    
    <h3>Dispositivos:</h3>
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dispositivo->search(),
                    'filter' => $dispositivo,
                    'columns' => array(
                        array(
                            'name' => 'id_dis',
                            'header'=>'ID',                            
                        ),
                        array(
                            'name' => 'funciona',
                            'header'=>'Funciona',
                            'type'=>'boolean'
                            
                        ),
                        
                        /*array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '40'), //ancho de la columna
                            'template' => '{view}', // botones a mostrar
                            'buttons'=>array(
                                "view"=>array(
                                    'label'=>'Detalles',                    
                                    'url'=>'Yii::app()->createUrl("/DetalleDispo/ViewbyPk?id_dispo=$data->id_dispositivo")')),
                        ),*/
                    ),
                ));
            ?>
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

