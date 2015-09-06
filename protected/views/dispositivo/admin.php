<?php
/* @var $this DispositivoController */
/* @var $model Dispositivo */
?>

<h1>Dispositivos Almacenados</h1>

<?php
$this->widget('booster.widgets.TbExtendedGridView', array(
         'id' => 'dispositivo-grid',
         'dataProvider' => $model->search(),
         'filter' => $model,
         'columns' => array(
                array(
                    'name' => 'mac',
                ),
                array(
                    'name' => 'modelo',
                ),
                array(
                    'name' => 'version',
                ),
                array(
                    'name' => 'funciona',
                ),  
             
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{delete} {update}', // botones a mostrar
                    'buttons' => array(
                        "delete" => array(
                            'label' => 'Eliminar',                             
                            'click' => 'function(){return confirm("Desea eliminar todos los registro del dispositivo?");}',
                            'url'=> 'Yii::app()->createUrl("/Dispositivo/Eliminar?id=$data->id_dis")'
                        ),
                        "update" => array(
                            'label' => 'Modificar',                                                           
                        ),
                    ),
                ),
            ),
    )
);

//BOTON ELIMINAR
$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Eliminar todo',
        'context' => 'warning',
        'htmlOptions' => array(
            'onclick' => 'js:bootbox.confirm("Se borraran todos los datos. Esta seguro?", '
            . 'function(confirmed){'
            . 'if (confirmed){'
            .  ' window.location.href="DeleteAll"}})'
        ),
    )
);
?>


<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'myModal')
        ); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Actualizar datos</h4>
    </div>
 
    <div class="modal-body">
        <p>Formulario de actulizacion</p>
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'label' => 'Save changes',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Click me',
        'context' => 'primary',
        'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
        ),
    )
);?>
          </div>
          