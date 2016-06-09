
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
	array('label'=>'Agregar Dispositivo', 'url'=>array('dispositivo/create')),
        array('label'=>'Calibrar Dispositivo', 'url'=>array('Calibracion/create?id_disp=')),
	array('label'=>'Agregar Sucursal', 'url'=>array('sucursal/create')),
//        array('label'=>'Eliminar todo', 'url'=>'#', 'linkOptions'=>array('onclick'=>'show_confirm()')),
        array('label'=>'Solucionar Inconveniente', 'url'=>array('asignarinspector/create')),
        array('label'=>'Historial Alarmas', 'url'=>array('alarma/histo')),
        
);
?>

<h1>Alarmas</h1>

<p>
<b></b> 
</p>

<div id="browse_app">
  <a class="btn btn-large btn-info" href="preadmin">Pre-Alarmas</a>
</div>

<div class="form">
    <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderAlarma,
            'columns' => array(    
                array(
                    'name' => 'id_dis',
                            'value' => 'CHtml::link($data["id_dis"], Yii::app()
                                ->createUrl("DetalleDispo/VerDetalle",array("id"=>$data["id_dis"])))',
                            'type'  => 'raw', 
                    'header'=>'Dispositivo',
                ),
                array(
                    'name' => 'fecha',
                    'header'=>'Fecha',
                    'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data["fecha"]))',
                ),                        
                array(
                    'name' => 'hs',
                    'header'=>'Hora'
                ),                        
                array(
                    'name' => 'alarma',
                    'header'=>'Descripcion'
                ), 
                array(
                    'name' => 'direccion',
                    'header'=>'Direccion'
                ),
                
                array(
                    'name' => 'solucionado',
                    'header'=>'Solucionado',
                    'value'=>'$data["solucionado"]== 0 ? "NO" : "SI"',  
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{view} {delete} ', // botones a mostrar
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

