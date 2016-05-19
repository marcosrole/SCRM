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
  .modal.in .modal-dialog {
    width: 60%;
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


<?php
/* @var $this HistoasignacionController */
/* @var $model Histoasignacion */

$this->breadcrumbs=array(
	'Histoasignacions'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Histoasignacion', 'url'=>array('index')),
	array('label'=>'Generar Asignacion', 'url'=>array('create')),
//	array('label'=>'View Histoasignacion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Historico de Asignacion', 'url'=>array('list')),
);
?>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
            
    <div class="campo">
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $DataProviderHistoAsig, 
                    
                    'columns' => array(                        
                        array(
                            'name' => 'dispositivo',
                            'header'=>'Dispositivo',                                                       
                        ),
                        
                        array(
                                'class' => 'booster.widgets.TbButtonColumn',
                               // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                                'template' => '{edit}', // botones a mostrar
                                'buttons' => array(
                                    'edit' => array
                                    (
                                        'label'=>'Modificar Dispositivo',
                                        'icon'=>'glyphicon glyphicon-pencil', 
                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodaldispositivo",array("id"=> ' . '$data["id"]))',                                       
                                        'options'=>array(
                                            'ajax'=>array(
                                                'type'=>'POST',
                                                'url'=>"js:$(this).attr('href')",
                                                'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                                            ),
                                        ),

//                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodaldispositivo",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
                                        //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
//                                        'url'=> 'Yii::app()->createUrl("semanatrabajo/view", array("id_usr"=> ' . '$data["id"])) ',
                                    ),                                                                                                
                                ),
                        ),
                        
//                        array(
//                            'class' => 'booster.widgets.TbButtonColumn',
//                            'htmlOptions' => array('width' => '10'), //ancho de la columna
//                            'template' => '{update}', // botones a mostrar
//                            'buttons' => array(
//                                    'update' => array(
//                                    'label' => 'Modificar Dispositivo',
////                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodaldispositivo",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
//                                    //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
//                                ),
//                                
//                            ),
//                        ),
                        
                        array(
                            'name' => 'sucursal',
                            'header'=>'Sucursal'
                        ),
                        array(
                            'name' => 'empresa',
                            'header'=>'Empresa'
                        ),
                        array(
                                'class' => 'booster.widgets.TbButtonColumn',
                               // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                                'template' => '{coordenadas}', // botones a mostrar
                                'buttons' => array(
                                    'coordenadas' => array
                                    (
                                        'label'=>'Modificar Dispositivo',
                                        'icon'=>'glyphicon glyphicon-map-marker', 
                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/ModalUpdateCoordenadas",array("id"=> ' . '$data["id"]))',                                       
                                        'options'=>array(
                                            'ajax'=>array(
                                                'type'=>'POST',
                                                'url'=>"js:$(this).attr('href')",
                                                'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                                            ),
                                        ),

//                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodaldispositivo",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
                                        //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
//                                        'url'=> 'Yii::app()->createUrl("semanatrabajo/view", array("id_usr"=> ' . '$data["id"])) ',
                                    ),                                                                                                
                                ),
                        ),
                        
                        array(
                                'class' => 'booster.widgets.TbButtonColumn',
                               // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                                'template' => '{edit}', // botones a mostrar
                                'buttons' => array(
                                    'edit' => array
                                    (
                                        'label'=>'Modificar Sucursal',
                                        'icon'=>'glyphicon glyphicon-pencil',                                                                               
                                        'url'=> 'Yii::app()->createUrl("/histoasignacion/ModificarModalEmpresa",array("id"=> ' . '$data["id"]))',                                       
                                        'options'=>array(
                                            'ajax'=>array(
                                                'type'=>'POST',
                                                'url'=>"js:$(this).attr('href')",
                                                'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                                            ),
                                        ),

                                    ),                                                                                                
                                ),
                        ),
//                        array(
//                            'class' => 'booster.widgets.TbButtonColumn',
//                            'htmlOptions' => array('width' => '10'), //ancho de la columna
//                            'template' => '{update}', // botones a mostrar
//                            'buttons' => array(
//                                    'update' => array(
//                                    'label' => 'Modificar empresa',
////                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/modificarmodalempresa",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
//                                    //'click' => 'function(){$("#parm-frame").attr("src",$(this).attr("href")); $("#parmdialog").dialog("open"); return false;}',
//                                ),
//                                
//                            ),
//                        ),
                        
                        array(
                            'name' => 'fechaAlta',
                            'header'=>'Fecha de Alta',
                            'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data["fechaAlta"]))'
                        ), 
                        
                        array(
                                'class' => 'booster.widgets.TbButtonColumn',
                               // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                                'template' => '{eliminar}', // botones a mostrar
                                'buttons' => array(
                                    'eliminar' => array
                                    (
                                        'label'=>'Modificar Sucursal',
                                        'icon'=>'glyphicon glyphicon-trash',   
                                        'click' => 'function(){return confirm("Desea eliminar la asignacion realizada?");}',
                                        'url'=> 'Yii::app()->createUrl("/Histoasignacion/DeleteHisAsi",array("id"=> ' . '$data["id"]))',                                       
                                    ),                                                                                                
                                ),
                        ),
                       
//                         array(
//                            'class' => 'booster.widgets.TbButtonColumn',
//                            'htmlOptions' => array('width' => '10'), //ancho de la columna
//                            'template' => '{delete}', // botones a mostrar
//                            'buttons' => array(
//                                "delete" => array(
//                                    'label' => 'Dar de baja',                             
//                                    'click' => 'function(){return confirm("Desea dar de baja ésta asignación?");}',
////                                    'url'=> 'Yii::app()->createUrl("/histoasignacion/eliminar",array("id_dis"=>"$data->id_dis","id_suc"=>"$data->id_suc"))',                                       
//                                ),                                
//                            ),
//                        ),                        
                    ),                    
                ));                
            ?> 
    </div>    
        <?php $this->endWidget(); ?>
        
    </div>

<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4> Modificaciones </h4>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">

    </div>

<?php $this->endWidget(); ?>

