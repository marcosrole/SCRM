<style>
    .login {
    display: -webkit-inline-box;
    margin-left: 40%;
    
}
</style>
    

    
<?php
$this->widget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'Sistema de Control de Ruidos Molestos',
        'encodeHeading'=>'true',
        'htmlOptions' => array(),
        'headingOptions'=> array(),
    )
);
?>

 <?php $this->renderPartial(
                        '_form',
                        array(
                            'usuario'=>$usuario,
                            'error'=>$error,
                        )); ?>
