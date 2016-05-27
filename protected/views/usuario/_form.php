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
));?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/usuario.css" media="screen, projection">
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




   
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
            
    <div class="usuario">
        <div class="columna1">
            <div class="name">
                <?php echo $form->textFieldGroup($usuario, 'name', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>                
            </div>
            <?php if(!$update){?>
                <div class="pass">
                    <?php echo $form->textFieldGroup($usuario, 'pass', array ('wrapperHtmlOptions' =>  array(  'class' => 'col-sm-5'),));?>                    
                </div>            
            <?php }?>
            
        </div>
        
        <div class="clumna2">
            <div class="nivel">
                <?php echo $form->checkboxListGroup(
			$rol,
			'id',
			array(
				'widgetOptions' => array(
					'data' => $array_rol,
				),
				'hint' => '<strong>Note:</strong> Roles habilitados. Puede seleccionar mas de un rol para un usuario.'
			)
		); ?>
                
            </div>        
        </div>
    </div>
        
    <div class="persona">
        <div class="row1">
            <div class="nombre">
                <?php echo $form->textFieldGroup($persona, 'nombre', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>                
            </div>

            <div class="apellido">
                <?php echo $form->textFieldGroup($persona, 'apellido', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>                
            </div>

            <div class="sexo">
                <?php echo $form->dropDownListGroup($persona, 'sexo', array('wrapperHtmlOptions' => array('class' => 'col-sm-5', ),'widgetOptions' => array(
                    'data' => array('M', 'F'),
                    'htmlOptions' => array(),)));?>
            </div>
        </div>
        
        <div class="row2">
            <div class="tipodni">
                <?php echo $form->dropDownListGroup($persona, 'tipo_dni', array ('wrapperHtmlOptions' => array( 'class' => 'col-sm-5',),'widgetOptions' => array( 
                    'data' => array('DNI', 'LE', 'LC'),'htmlOptions' => array(),) )); ?>
            </div>

            <div class="dni">            
                <?php echo $form->textFieldGroup($persona, 'dni', array ('hint' => 'sin punto (.) ej: 23456545', 'widgetOption'  =>  'Checsdasadut', 'wrapperHtmlOptions' => array('class' => 'col-sm-5',),'width' => '40',)); ?>
            </div>           

            <div class="cuil">
                <?php echo $form->textFieldGroup($persona, 'cuil', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            </div> 
            
            <div class="zona-sucursal">
                        
                        <?php echo $form->dropDownListGroup($zona,'id',array('hint' => 'Inspectores', 'id'=>'dropdown','wrapperHtmlOptions' => array('class' => 'col-sm-5',),
                                    'widgetOptions' => array(
                                            'data' => $listZona,
                                            //'htmlOptions' => array('prompt'=>'Zona'),
                                    )
                                ),
                                array(
                                    'options' => array('5'=>array('selected'=>true)),
                                )
                        ); ?>
                        
                        <div class="link">
                            <?php $link= "http://" .  $_SERVER['HTTP_HOST'] . "/SCRM/zona/index"; ?>
                            <a href=<?php echo $link ?> >Ver zonas</a>
                        </div>
                
                            
                        
                    </div> 
            
        </div>
    </div>
   
    <div class="direccion">
        <div class="calle">
            <?php echo $form->textFieldGroup($direccion, 'calle', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div>           
    
        <div class="altura">
            <?php echo $form->textFieldGroup($direccion, 'altura', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div>           
        
        <div class="piso">
            <?php echo $form->textFieldGroup($direccion, 'piso', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div>           
        <div class="depto">
            <?php echo $form->textFieldGroup($direccion, 'depto', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div> 
            
        <div class="localidad">
            <?php echo $form->dropDownListGroup($localidad, 'id', array('wrapperHtmlOptions' => array('class' => 'col-sm-5',),'widgetOptions' => array(
                'data' => $lista_localidades,
            'htmlOptions' =>  array(),)));?>
        </div>
    </div>
        
    <div class="tel">
        <div class="telefono">
            <?php echo $form->textFieldGroup($persona, 'telefono', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div>
    
        <div class="celular">
            <?php echo $form->textFieldGroup($persona, 'celular', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
        </div>
    </div>
    
    
    
        <div class="email">
            <?php echo $form->textFieldGroup($persona, 'email', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
            <?php echo $form->error($persona, 'email'); ?>
        </div>

        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Cargar', 'context' => 'success','buttonType' => 'submit',));?>
        </div>

    <?php $this->endWidget(); ?>        
</div>

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
));?>