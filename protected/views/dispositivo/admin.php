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
/* @var $this DispositivoController */
/* @var $model Dispositivo */
?>

<h1>Dispositivos Almacenados</h1>

<?php
$this->widget('booster.widgets.TbExtendedGridView', array(
         'id' => 'dispositivo-grid',
         'dataProvider' => $dispositivo->search(),
         'filter' => $dispositivo,
         'columns' => array(
                array(
                    'name' => 'id',
                    'header' => 'ID',
                ),
                array(
                    'name' => 'mac',
                    'header' => 'MAC',
                ),
                array(
                    'name' => 'modelo',
                    'header' => 'Modelo',
                ),
                array(
                    'name' => 'version',
                    'header' => 'Version',
                    'htmlOptions' => array('width' => 10),
                ),
                array(
                    'name' => 'funciona',
                    'header' => 'Funciona',
                    'htmlOptions' => array('width' => 10),
                ),  
             
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{delete}{update}', // botones a mostrar
                    'buttons' => array(
                        'delete' => array(
                            'label' => 'Eliminar',                             
                            'click' => 'function(){return confirm("Desea eliminar todos los registro del dispositivo?");}',
                            'url'=> 'Yii::app()->createUrl("/Dispositivo/Eliminar?id=$data->id")'
                        ),
                        'update' => array(
                            'label'=>'Modificar',
                            'icon'=>'glyphicon glyphicon-pencil',
                            'url'=>'Yii::app()->createUrl("dispositivo/modificar", array("id"=>$data->id,"mac"=>$data->mac,"modelo"=>$data->modelo,"version"=>$data->version,"funciona"=>$data->funciona))',
                            'options'=>array(
                                'class'=>'btn btn-small',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                                ),
                            ),
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width: 120px'),
                ),
            ),
    )
);

//BOTON ELIMINAR
$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Eliminar todo',
        'context' => 'warning',
        'htmlOptions' => array(
            'onclick' => 'js:bootbox.confirm("Se borraran todos los datos. Esta seguro?", '
            . 'function(confirmed){'
            . 'if (confirmed){'
            .  ' window.location.href="DeleteAll"}})'
        ),
    )
);
?>



            <!-- View Popup  -->
            <?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'viewModal')); ?>
                <!-- Popup Header -->
                <div class="modal-header">
                <div class="modal-header" style="padding:10px 10px;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
                </div>
                </div>
                <!-- Popup Content -->
                <div class="modal-body">
                <p>  <?php  ?></p>
                </div>
                <!-- Popup Footer -->
                <div class="modal-footer">
                <!-- close button -->
                <!-- close button ends-->
                </div>
            <?php $this->endWidget(); ?>
            <!-- View Popup ends -->          </div>
          