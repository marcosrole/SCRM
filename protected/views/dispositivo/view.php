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
$this->menu=array(
//	array('label'=>'List Profesor', 'url'=>array('index')),
	array('label'=>'Listado', 'url'=>array('list')),
//	array('label'=>'Update Profesor', 'url'=>array('update', 'id'=>$model->idProfesor)),
//	array('label'=>'Delete Profesor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idProfesor),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Profesor', 'url'=>array('admin')),
);
?>

<?php 
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => array(
            'id_dispositivo' => $model->id_dispositivo,
            'ubicacion' => $model->ubicacion,            
        ),
        'attributes' => array(
            array('name' => 'id_dispositivo', 'label' => '#'),
            array('name' => 'ubicacion', 'label' => 'Ubicacion'),
            
        ),
    )
);

?>