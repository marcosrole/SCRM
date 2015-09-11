<h1>
    Detalles del Dispositivo: <?php echo $id_dis ?>
</h1>

<?php

$this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'detalledispo_by_pk',
    'dataProvider' => $dataProvider,
//    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'db',
        ),
        array(
            'name' => 'distancia',
        ),
        array(
            'name' => 'fecha',
        ),
        array(
            'name' => 'hs',
        ),        
        ),
    )
);

?>

