<?php

$this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'usuario-grid-list',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'name',
        ),
        array(
            'name' => 'pass',
        ),
        array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array('width' => '40'), //ancho de la columna
            'template' => '{delete}', // botones a mostrar
//            'updateButtonUrl' => 'Yii::app()->createUrl("/nombre_modelo/update?id=$data->id" )', // url de la acción 'update'
//            'deleteButtonUrl' => 'Yii::app()->createUrl(homeUrl . "/nombre_modelo/delete?id=$data->id" )', // url de la acción 'delete'            
//            'buttons' => array(
//                'accion_nueva' => array(//botón para la acción nueva
//                    'label' => 'descripción accion_nueva', // titulo del enlace del botón nuevo
//                    'imageUrl' => Yii::app()->request->baseUrl . '/ruta_carpeta/nombre_foto', //ruta icono para el botón
//                    'url' => 'Yii::app()->createUrl("/nombre_modelo/accion_nueva?id=$data->id" )', //url de la acción nueva
//                ),
//            ),
        ),
    ),
));
?>
