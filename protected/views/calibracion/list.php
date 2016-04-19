<?php

/* @var $this CalibracionController */
/* @var $calibracion Calibracion */

$this->menu=array(	
	array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
	
);
?>

<h1>Calibraciones de dispositivos <?php ?></h1>

<div class="row">
            <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $DataProviderCalibracion,
                    'columns' => array(                        
                        array(
                            'name' => 'id_dis',
                            'header'=>'ID Dispositivo'
                        ),
                        array(
                            'name' => 'sucursal',
                            'header'=>'Sucursal'
                        ),
                        array(
                            'name' => 'direccion',
                            'header'=>'Direccion'
                        ),
                        array(
                            'name' => 'db_permitido',
                            'header'=>'dB Permitido'
                        ),
                        array(
                            'name' => 'dist_permitido',
                            'header'=>'Distancia Permitido'
                        ),  
                        array(
                            'name' => 'fecha',
                            'header'=>'Fecha',
                            'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data["fecha"]))'
                        ), 
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                           // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{view} {update}', // botones a mostrar
                            'buttons' => array(
                                'view' => array(
                                    'label' => 'Detalles',  
                                    'url'=> 'Yii::app()->createUrl("Calibracion/view", array("id"=> ' . '$data["id"])) ',
                                 
                                ),                        
                                'update' => array(
                                    'label' => 'Actualizar',                                                         
                                    'url'=> 'Yii::app()->createUrl("Calibracion/update", array("id"=> ' . '$data["id"])) ',
                                ),                
                            ),
                            //'htmlOptions'=>array('style'=>'width: 120px'),
                            ),
                    ),
                    
                ));
            ?> 
	</div>
