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
    .boton{
       margin-left: 60%;
    margin-top: 25%; 
    }
    .subtitulo{
        margin-left: 50%;
    }
    .jumbotron {
    position: relative;
    //background: #000 url("jumbotron-bg.png") center center;
    background: url("images/SCRMTitulo.png") center center;
    background-position: 50% 50%;
    background-size: 70%;
    background-repeat: no-repeat;
    width: 100%;
    height: 70%;
    //background-size: cover;
    overflow: hidden;
    
    border-radius: 69px 69px 69px 69px;
-moz-border-radius: 69px 69px 69px 69px;
-webkit-border-radius: 69px 69px 69px 69px;
border: 3px solid #4b6094;
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

<div class="jumbotron">  
    <div class="container">
        
        
        <div class="subtitulo">
            <p>Proyecto Final: Ingenieria en Informatica.</p>
        </div>
        <div class="boton">
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
            
        </div>
        
         
    </div>
</div>  




<?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4> Inicio de Sesión </h4>
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

