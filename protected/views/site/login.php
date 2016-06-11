<style>
   
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
            //'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    ); ?>
            
            <h5 class="note">Los campos con <span class="required">*</span> son obligatorios.</h5>
            
            <?php echo $form->textFieldGroup($usuario, 'name'); ?>    
            <?php echo $form->passwordFieldGroup($usuario, 'pass'); ?>    
            <?php if($error){ ?>
                <font color="red">
                    <h5>
                        Usuario o contraseña incorrecto.
                    </h5>            
                </font>           
            <?php }
    
             $this->widget('booster.widgets.TbButton', array('label' => 'Iniciar Sesion','size' => 'large','context' => 'primary','buttonType'=>'submit',)); 
   
    $this->endWidget();
    ?>
</div>