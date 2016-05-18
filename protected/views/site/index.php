 <style>
    .modal-header, h4, .close {
        background-color: #19A3FF;
        color:white !important;
        text-align: center;
        font-size: 30px;
    }
    .modal-footer {
        background-color: #19A3FF;
    }
    .modal.in .modal-dialog {
    width: 25%;
    }
</style>




 <?php
    $this->widget('booster.widgets.TbAlert', array(
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            // success, info, warning, error or danger
            'success' => array('closeText' => '&times;'),
            'info', // you don't need to specify full config
            'warning' => array('closeText' => false),
            'error' => array('closeText' => false),
        ),
    ));
?>

<?php $this->beginWidget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'Sistema de Control de Ruidos Molestos',
    )
); ?>
 
    <p>Proyecto Final: Ingenieria en Informatica.</p>
 
    <p><?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'size' => 'large',
                'url' => array('site/about#openModal'),
                'label' => 'Iniciar Sesion',
                 'htmlOptions'=>array(
                    'data-toggle'=>'modal',
                    'data-target'=>'#myModal',
                )
            )
        ); ?></p>
 
<?php $this->endWidget(); ?>
   



<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4> SCRM </h4>
    </div>
    <div class="modal-body">
         <?php $this->renderPartial(
                        '_form',
                        array(
                            'usuario'=>$usuario,
                            'error'=>$error,
                        )); ?>
    </div>
    <div class="modal-footer">

    </div>

<?php $this->endWidget(); ?>

