<style>
    .form {
        width: 50%;
    margin-left: 25%;
}

</style>
<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Contáctenos</h1>


<p>
Por cualquier inconveniente o consulta,por favor complete el siguiente formulario. Gracias
</p>

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
    
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
        <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
        <div class="fromEmail">
            <?php echo $form->textFieldGroup($model, 'fromEmail', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            <?php echo $form->error($model, 'fromEmail'); ?>
        </div>
        <div class="subject">
            <?php echo $form->textFieldGroup($model, 'subject', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            <?php echo $form->error($model, 'subject'); ?>
        </div>
        <div class="message">
            <?php echo $form->textAreaGroup(
			$model,
			'message',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				)
			)
		); ?>
        </div>

        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Enviar', 'context' => 'success','buttonType' => 'submit',));?>
        </div>

    <?php $this->endWidget(); ?>        
</div>


