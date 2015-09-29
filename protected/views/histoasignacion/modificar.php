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

<h1>Modificaciones de Asignacion</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
            
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataProvider,
                    'filter' => $histoasignacion,
                    'columns' => array(                        
                        array(
                            'name' => 'id_dis',
                            'header'=>'Dispositivo',                                                       
                        ),
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{update}', // botones a mostrar
                            'buttons' => array(
                                    'update' => array(
                                    'label' => 'Modificar Dispositivo',
                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodaldispositivo",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
                                    //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
                                ),
                                
                            ),
                        ),
                        array(
                            'name' => 'id_suc',
                            'header'=>'Empresa'
                        ),
                                                array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{update}', // botones a mostrar
                            'buttons' => array(
                                    'update' => array(
                                    'label' => 'Modificar empresa',
                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodalempresa",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
                                    //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
                                ),
                                
                            ),
                        ),
                        array(
                            'name' => 'fechaAlta',
                            'header'=>'Fecha de Alta',
                            'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data->fechaAlta))'
                        ),
                        array(
                            'name' => 'fechaModif',
                            'header'=>'Fecha de Modificacion'
                        ),
                        array(
                            'name' => 'observacion',
                            'header'=>'Obervaciones'
                        ),
                         array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{delete}', // botones a mostrar
                            'buttons' => array(
                                "delete" => array(
                                    'label' => 'Dar de baja',                             
                                    'click' => 'function(){return confirm("Desea dar de baja ésta asignación?");}',
                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/eliminar",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
                                ),                                
                            ),
                        ),                        
                    ),                    
                ));                
            ?> 
    </div>    
        <?php $this->endWidget(); ?>
        
    </div>

    

