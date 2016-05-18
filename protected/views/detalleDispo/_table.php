<?php
$self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
header("refresh:10; url=$self"); //Refrescamos cada 10 segundos
    $this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'detalledispo_by_pk',
    'dataProvider' => $dataProvider,
     'responsiveTable' => true,
    'columns' => array(
        array(
            'name' => 'db',            
        ),
//        array(
//            'name' => 'distancia',
//            'htmlOptions'=>array('width'=>'25%'),
//        ),
        array(
            'name' => 'hs',
//            'htmlOptions'=>array('width'=>'25%'),
        ),
        array(
            'name' => 'fecha',
             'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data["fecha"]))',
//            'htmlOptions'=>array('width'=>'25%'),
        ),
                
        ),
    )
);
