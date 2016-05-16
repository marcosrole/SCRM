<?php
/* @var $this CalibracionController */
/* @var $model Calibracion */

$this->breadcrumbs=array(
	'Calibracions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Calibraciones', 'url'=>array('list')),
);
?>

<h1>Calibracion de Dispositivo</h1>
<p class="note">Seleccione un dispositivo a calibrar.</p>
<p> <i>Si el dispositivo no se encuentra en la lista, por favor asigne el dispositivo a una sucursal.</i> <a href=<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/SCRM/Histoasignacion/crear"?>>Haga clic aquí </a> </p>
<div class="row">
            <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $dataprovieder,
                    'filter' => $dispositivo,
                    'columns' => array(
                        array(
                            'name'  => 'id',
                            'value' => 'CHtml::link($data->id, Yii::app()
                                ->createUrl("DetalleDispo/VerDetalle",array("id"=>$data->id)))',
                            'type'  => 'raw',                            
                            'header'=>'Nro. Identificación'
                        ),
                        array(
                            'name' => 'mac',
                            'header'=>'MAC'
                        ),
                        array(
                            'name' => 'modelo',
                            'header'=>'Modelo'
                        ),
                        array(
                            'name' => 'version',
                            'header'=>'Version'
                        ),
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'htmlOptions' => array('width' => '40'), //ancho de la columna
                            'template' => '{calibrar}', // botones a mostrar
                            'buttons'=>array(
                                "calibrar"=>array(
                                    'label'=>'Calibrar',
                                    'icon'=>'glyphicon glyphicon-stats',                                    
                                    'url'=> 'Yii::app()->createUrl("/calibracion/create?id_disp=$data->id")'
                                    )),
                        ),
                    ),
                ));
            ?> 
	</div>

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
                
            ),
        ));
?>

<?php $this->renderPartial('_form', array('calibracion'=>$calibracion)); ?>




