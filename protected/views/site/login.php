<style>
    .login{
        display: inline-block;
        margin-left: 40%;
        margin-top: 10%;
    }
</style>
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>




<div class="login">
    <?php 
    $form = $this->beginWidget('booster.widgets.TbActiveForm',
        array(
            'id' => 'UsuarioForm',
            'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>
            
            <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
            
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