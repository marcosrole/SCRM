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
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '  <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                ERROR: El sistema no funciona correctamente.
                </div>';
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";        
    }
?>





<div class="modal-header" style="padding:35px 50px;">    
    <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
    
    
    
</div>


<div class="modal-body" style="padding:35px 50px;">
    <div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    <div class="label_original">
        <h2>Dispositivo: <?php echo $dispositivo_original ?> </h2>            
    </div>
    <div class="dato_nuevo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresa-grid-list',
                    'dataProvider' => $dataProviderDispositivo,
                    'filter' => $dispositivo,
                    'columns' => array(                        
                        array(
                            'name' => 'id',
                            'header'=>'ID',                                                        
                        ),
                        array(
                            'name' => 'mac',
                            'header'=>'MAC'
                        ),
                         array(
                            'id' => 'selectedDispositivo',
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
</div>
</div>

<div class="modal-footer" style="padding:35px 50px;">
    
</div>

