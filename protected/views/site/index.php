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

<?php 
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'UsuarioForm',
            'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>
    <?php echo $form->textFieldGroup($usuario, 'name'); ?>
    
    <?php echo $form->passwordFieldGroup($usuario, 'pass'); ?>
    
    <?php if($error){ ?>
        <font color="red">
            Usuario o contraseña incorrecto.
            <br>
        </font>           
    <?php }
    
     $this->widget('booster.widgets.TbButton', 
    array(
        'label' => 'Entrar',
        'context' => 'success',
        'buttonType'=>'submit', 
        )); 

    
    $this->endWidget();


?>