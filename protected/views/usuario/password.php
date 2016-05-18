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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/usuario.css" media="screen, projection">
<style>
  .usuario {
    display: -webkit-inline-box;
    margin-left: 50%;
    margin-top: 5%;
}
.boton {
    margin-left: 55%;
}
</style>
    <?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
//	'Usuarios'=>array('index'),
//	$usuario->name=>array('view','id'=>$usuario->id),
//	'Update',
);

$this->menu=array(
	array('label'=>'Listar Usuario', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),        
//	array('label'=>'View Usuario', 'url'=>array('view', 'id'=>$usuario->id)),
//	array('label'=>'Manage Usuario', 'url'=>array('admin')),
);
?>

<h1>Actualizar Usuario <?php ?></h1>




<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
        $this->widget('booster.widgets.TbAlert', array(
            'fade' => true,
            'closeText' => '&times;', // false equals no close link
            'events' => array(),
            'htmlOptions' => array(),
            'userComponentId' => 'user',
            'alerts' => array( // configurations per alert type
                // success, info, warning, error or danger
                'success' => array('closeText' => '&times;'),
                'info', // you don't need to specify full config
                'warning' => array('closeText' => false),
                
            ),
        ));
?>
   
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array ('id' =>  'verticalForm',)); ?>
    <div class="usuario">
        <div class="columna1">
            <div class="name">
                Usuario seleccionado: <strong><?php echo $usuario->name; ?></strong>
                <p> 
                    
                    
                    
                    
                </p>
            </div>
            
            <div class="pass">
                <?php echo $form->textFieldGroup($usuario, 'pass', array ('hint' => 'Nueva Contraseña', 'wrapperHtmlOptions' =>  array(  'class' => 'col-sm-5'),));?>
                <?php echo $form->error($usuario, 'pass'); ?>
            </div>            

            
        </div>        
    </div>
        

        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Cargar', 'context' => 'success','buttonType' => 'submit',));?>
        </div>

    <?php $this->endWidget(); ?>        
</div>
