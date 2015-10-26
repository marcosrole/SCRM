<div class="login">
    <?php 
    $form = $this->beginWidget('booster.widgets.TbActiveForm',
        array(
            'id' => 'UsuarioForm',
            'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>
            <?php echo $form->textFieldGroup($usuario, 'name'); ?>    
            <?php echo $form->passwordFieldGroup($usuario, 'pass'); ?>    
            <?php if($error){ ?>
                <font color="red">
                    <p>
                        Usuario o contraseña incorrecto.
                    </p>            
                </font>           
            <?php }
    
             $this->widget('booster.widgets.TbButton', array('label' => 'Entrar','context' => 'success','buttonType'=>'submit',)); 
   
    $this->endWidget();
    ?>
</div>