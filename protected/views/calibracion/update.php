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
<?php
/* @var $this CalibracionController */
/* @var $model Calibracion */

$this->breadcrumbs=array(
	'Calibracions'=>array('index'),
	$calibracion->id=>array('view','id'=>$calibracion->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Calibraciones', 'url'=>array('list')),
	array('label'=>'Calibrar Dispositivo', 'url'=>array('calibracion/create?id_disp')),
);
?>

<h1>Actualizar valores de aceptación <?php  ?></h1>

<h3>Datos originales: <?php  ?></h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$calibracion,
	'attributes'=>array(
		'id',
		'db_permitido',
		'dist_permitido',
		'id_dis',
		'id_suc',
	),
)); ?>

<div class="form">
    <br>
<?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($calibracion); ?>
        	
	<div class="row">
            <?php echo $form->textFieldGroup($calibracion,'db_permitido',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>		
	</div>

	<div class="row">
            <?php echo $form->textFieldGroup($calibracion,'dist_permitido',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
	</div>

	<div class="row buttons">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Actualizar', 'context' => 'success','buttonType'=>'submit',));         ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->