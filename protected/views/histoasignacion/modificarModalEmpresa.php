<head>  
  <style>
  .modal-header, h4, .close {
      background-color: #19A3FF;
      color:white !important;
      text-align: center;
      font-size: 30px;
      
  }
  .modal-footer {
      background-color: #19A3FF;
      
  }
  </style>
</head>

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



<?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    <div class="label_original">
        <h2>Empresa: <?php echo $empresa_original ?> </h2>            
    </div>
    <div class="dato_nuevo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresa-grid-list',
                    'dataProvider' => $dataProviderSucursal,                 
                    'filter' => $sucursal,
                    'columns' => array(                        
                        array(
                            'name' => 'cuit_emp',
                            'header'=>'CUIT',                                                        
                        ),
                        array(
                            'name' => 'nombre',
                            'header'=>'Sucursal'
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