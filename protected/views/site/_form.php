<div class="login">
    <?php 
    $form = $this->beginWidget('booster.widgets.TbActiveForm',
        array(
            'id' => 'UsuarioForm',
            //'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>
            <?php echo $form->textFieldGroup($usuario, 'name'); ?>    
            <?php echo $form->passwordFieldGroup($usuario, 'pass'); ?>    
            
    
            <?php$this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'size' => 'large',
                //'url' => array('site/about#openModal'),
                'label' => 'Iniciar Sesion',
                 
            )
             ); 
            
            <?php if($error){ ?>
                <font color="red">
                    <h5> Usuario o contraseña incorrecto. </h5>            
                </font>           
            <?php }
       
             //$this->widget('booster.widgets.TbButton', array('label' => 'Entrar','context' => 'success','buttonType'=>'submit',)); 
   
    $this->endWidget();
    ?>
</div>