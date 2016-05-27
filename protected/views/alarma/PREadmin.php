
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

<?php Yii::app()->clientScript->registerScript("confirm","
        function show_confirm()
        {       
                bootbox.confirm('¿Esta seguro que desa eliminar todas las alarmas?', function(result) {
                    if(result) {window.location.href='EliminarTodo'}                    
                  }); 
        }        
",CClientScript::POS_HEAD);
?>

<?php ?>

 <?php
$this->widget('booster.widgets.TbAlert', array(
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array(// configurations per alert type
        // success, info, warning, error or danger
        'success' => array('closeText' => '&times;'),
        'info', // you don't need to specify full config
        'warning' => array('closeText' => false),
        'error' => array('closeText' => false),
    ),
));
?>



<?php
/* @var $this AlarmaController */
/* @var $model Alarma */

$this->breadcrumbs=array(
	'Alarmas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Alarmas', 'url'=>array('alarma/admin')),            
        
);
?>

<h1>PRE - Alarmas</h1>

<p>
<b></b> 
</p>



<div class="form">
    <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderAlarma,
            'columns' => array( 
                array(
                    'name' => 'id',
                    'header'=>'#'
                ),                                
                array(
                    'name' => 'fecha',
                    'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data["fecha"]))',
                    'header'=>'Fecha'
                ),                        
                array(
                    'name' => 'hs',
                    'header'=>'Hora'
                ), 
                array(
                    'name' => 'id_dis',
                    'value' => 'CHtml::link($data["id_dis"], Yii::app()
                                ->createUrl("DetalleDispo/VerDetalle",array("id"=>$data["id_dis"])))',
                            'type'  => 'raw',
                    'header'=>'Dispositivo'
                ), 
                array(
                    'name' => 'alarma',
                    'header'=>'Descripcion'
                ), 
                array(
                    'name' => 'sucursal',
                    'header'=>'Sucursal'
                ), 
                array(
                    'name' => 'solucionado',
                    'header'=>'Solucionado',
                    'value'=>'$data["solucionado"]== 0 ? "NO" : "SI"',  
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{view} {email} {delete}', // botones a mostrar
                    'htmlOptions'=>array('width'=>'10%'),
                    'buttons' => array(
                       
                        "view"=>array(
                            'label'=>'Detalles', 
                              'url'=> 'Yii::app()->createUrl("alarma/view", array("id"=> ' . '$data["id"])) ',                                  
                                'options'=>array(
                                    'ajax'=>array(
                                        'type'=>'POST',
                                        'url'=>"js:$(this).attr('href')",
                                        'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                                    ),
                                ),                                    
                            ),
                        'email' => array(
                            'label' => 'Enviar E-mail',
                            'icon'=>'glyphicon glyphicon-envelope',
                            'url'=> 'Yii::app()->createUrl("alarma/Sendemail", array("id_alarma"=> ' . '$data["id"])) ',
                        ),
                        'delete' => array(
                            'label' => 'Eliminar Alarma',                            
                            'click' => 'function(){return confirm("Desea eliminar la empresa?");}',
                             'url'=> 'Yii::app()->createUrl("alarma/eliminar", array("id"=> ' . '$data["id"])) ',
                        ),
                    ),
                    //'htmlOptions'=>array('style'=>'width: 120px'),
                    ),
            ),

        ));
    ?> 
</div>
<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4> Detalles de Alarma </h4>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>

<?php $this->endWidget(); ?>

