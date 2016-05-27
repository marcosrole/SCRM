<style>
    .mac {
    width: 50%;
}
.modelo {
    width: 50%;
}
.version {
    width: 50%;
}
.tiempo {
        width: 20%;
}

</style>
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
    
        <div class="mac">            
            <?php echo $form->textFieldGroup($model,'id',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
        </div>
    
        <div class="mac">            
            <?php echo $form->textFieldGroup($model,'mac',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
        </div>   
    

        <div class="modelo">
		<?php echo $form->textFieldGroup($model,'modelo',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>
	</div>
    
        <div class="version">
		<?php echo $form->textFieldGroup($model,'version',array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),)); ?>		
	</div>
    
        <div class="tiempo">
		<?php echo $form->textFieldGroup($model,'tiempo',array(	'wrapperHtmlOptions' => array('class' => 'col-sm-5',),'append' => 'minutos')		); ?>
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
