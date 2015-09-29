<style>
    .detalles
    {
        width: 50%;           
        padding-left: 100;
    }
</style>

<h1>
    Detalles del Dispositivo: <?php echo $id_dis ?>
</h1>

<div class="detalles">
    <?php
    $this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'detalledispo_by_pk',
    'dataProvider' => $dataProvider,
     'responsiveTable' => true,

    'columns' => array(
        array(
            'name' => 'db',
            'htmlOptions'=>array('width'=>'25%'),
        ),
        array(
            'name' => 'distancia',
            'htmlOptions'=>array('width'=>'25%'),
        ),
        array(
            'name' => 'fecha',
            'htmlOptions'=>array('width'=>'25%'),
        ),
        array(
            'name' => 'hs',
            'htmlOptions'=>array('width'=>'25%'),
        ),        
        ),
    )
);

?>

</div>

