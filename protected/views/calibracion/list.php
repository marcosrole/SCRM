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
                    'dataProvider' => $calibracion->search(),
                    'filter' => $calibracion,
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'header'=>'ID'
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
                            'name' => 'id_dis',
                            'header'=>'ID Dispositivo'
                        ),
                        array(
                            'name' => 'id_suc',
                            'header'=>'ID Sucursal'
                        ),
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                           // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                            'template' => '{view} {update}', // botones a mostrar
                            'buttons' => array(
                                'view' => array(
                                    'label' => 'Detalles',                                                         
                                    'url'=> 'Yii::app()->createUrl("/Calibracion/view?id=$data->id")'
                                ),                        
                                'update' => array(
                                    'label' => 'Actualizar',                                                         
                                    'url'=> 'Yii::app()->createUrl("/Calibracion/update?id=$data->id")'
                                ),                
                            ),
                            //'htmlOptions'=>array('style'=>'width: 120px'),
                            ),
                    ),
                    
                ));
            ?> 
	</div>
