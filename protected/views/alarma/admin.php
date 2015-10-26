<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="bootstrap.min.js"></script>

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
        array('label'=>'Eliminar todo', 'url'=>'#', 'linkOptions'=>array('onclick'=>'show_confirm()')),
        
);
?>

<h1>Alarmas</h1>

<p>
<b>Nota:</b> 
</p>

<div class="form">
    <?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(                                                       
                array(
                    'name' => 'id_dis',
                    'header'=>'Dispositivo',
                    'htmlOptions'=>array('width'=>'2%'),
                ),
                array(
                    'name' => 'id_suc',
                    'header'=>'Sucursal'
                ),                                
                array(
                    'name' => 'fecha',
                    'header'=>'Fecha'
                ),                        
                array(
                    'name' => 'hs',
                    'header'=>'Hora'
                ),                        
                array(
                    'name' => 'descripcion',
                    'header'=>'Descripcion'
                ),                 
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{view}    {email} {delete}', // botones a mostrar
                    'htmlOptions'=>array('width'=>'10%'),
                    'buttons' => array(
                        'view' => array(
                            'label' => 'Detalles',                                                         
                            'url'=> 'Yii::app()->createUrl("/alarma/view?id=$data->id")'
                        ),                                                
                        'email' => array(
                            'label' => 'Enviar E-mail',
                            'icon'=>'glyphicon glyphicon-envelope',
                            'url'=> 'Yii::app()->createUrl("/alarma/Sendemail?id_alarma=$data->id")'
                        ),
                        'delete' => array(
                            'label' => 'Eliminar Alarma',                            
                            'click' => 'function(){return confirm("Desea eliminar la empresa?");}',
                            'url'=> 'Yii::app()->createUrl("alarma/eliminar?id=$data->id")', 
                        ),
                    ),
                    //'htmlOptions'=>array('style'=>'width: 120px'),
                    ),
            ),

        ));
    ?> 
</div>
    

