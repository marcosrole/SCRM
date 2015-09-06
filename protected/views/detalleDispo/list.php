<h1>
    Detalles del Dispositivo: <?php echo $id_dispo ?>
</h1>

<?php

$this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'detalledispo_by_pk',
    'dataProvider' => $dataProvider,
//    'filter' => $model,
    'columns' => array(
        array(
            'name' => 's_db',
        ),
        array(
            'name' => 's_dist',
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

