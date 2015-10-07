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
                'error' => array('closeText' => false),                
            ),
        ));
?>
<?php
/* @var $this DetalleDispoController */
/* @var $model DetalleDispo */

$this->breadcrumbs=array(
	'Detalle Dispos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cargar Detalles', 'url'=>array('DetalleDispo/create')),	
        array('label'=>'Listar Dispositivos', 'url'=>array('Dispositivo/list')),
        array('label'=>'Calibrar Dispositivo', 'url'=>array('Calibracion/create?id_disp=')),
);
?>

<h1>Nuevo Dispositivo</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>
    
        <div class="row">            
            <?php echo $form->textFieldGroup(
			$model,
			'mac',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
                            'width' => '40',
                            
			)
		); ?>
            <?php echo $form->error($model,'mac'); ?>
        </div>   
    

        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'modelo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'modelo'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->textFieldGroup(
			$model,
			'version',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),                            
			)
		); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>
        
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', 
                array(
                    'label' => 'Cargar',
                    'context' => 'success',
                    'buttonType'=>'submit', 
                    )); 
        ?>        
    </div>

    <?php $this->endWidget(); ?>
</div>
