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

<?php $this->menu=array(
	array('label'=>'Cargar Dispositivo', 'url'=>array('dispositivo/create')),	
        array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
        
);

?>


<h1>
    Dispositivos asignados
</h1>

<div class="form">
<?php


$this->widget('booster.widgets.TbGridView', array(
    'id' => 'dispositivo-grid-list',
    'dataProvider' => $dispositivos,
     'summaryText'=>'Página {page}-{end} de {count} resultados.',
    'columns' => array(
      array(
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('width' => '40'), //ancho de la columna
            'template' => '{view}', // botones a mostrar
            'buttons'=>array(
                "view"=>array(
                    'label'=>'Detalles',    
                    'url'=> 'Yii::app()->createUrl("DetalleDispo/VerDetalle", array("id"=> ' . '$data["id"])) ',
                    )),
          'htmlOptions'=>array('width'=>'5%'),
          ),
                    
        array(
            'name' => 'id',
            'header'=>'ID',
            'htmlOptions'=>array('width'=>'5%'),            
        ),
        array(
            'name' => 'mac',
            'header'=>'MAC',
            'htmlOptions'=>array('width'=>'15%'),           
        ),
        array(
            'name' => 'sucursal',
            'header'=>'Sucursal',
            'htmlOptions'=>array('width'=>'2O%'),                      
        ),
        array(
            'name' => 'direccion',
            'header'=>'Direccion',
            'htmlOptions'=>array('width'=>'4O%'),
        ),
         
        array(
            'name' => 'funciona',
            'header'=>'Habilitado',
//            'value'=> '($data->anAttribute > 10) ? "<a href=\"#\";><span class=\"icon-gift\"></span></a>" : "<a href=\"#\";><span class=\"icon-camera\"></span></a>"',
            'value'=>'$data["funciona"]== 0 ? "Deshabilitado" : "Habiilitado"', 
             'htmlOptions'=>array('width'=>'10%'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('width' => '5%'), //ancho de la columna
            'template' => '{habilitar} {deshabilitar} ', // botones a mostrar
            'buttons'=>array(
                'habilitar'=>array(
                   //'type'=>'raw',
                   'label'=>'Habilitar',
                    'icon'=>'glyphicon glyphicon-ok',
                   'visible' => '$data["funciona"] == "0"',   
                   'url'=> 'Yii::app()->createUrl("Dispositivo/habilitardispositivo", array("id"=> ' . '$data["id"])) ',
                 ),
                'deshabilitar'=>array(
                   //'type'=>'raw',
                   'label'=>'Deshabilitar',
                   'visible' => '$data["funciona"] == "1"',
                   'icon'=>'glyphicon glyphicon-remove',
                    'url'=> 'Yii::app()->createUrl("Dispositivo/habilitardispositivo", array("id"=> ' . '$data["id"])) ',
                 ),
             ),
        ),
    ),
));
?>
</div>
