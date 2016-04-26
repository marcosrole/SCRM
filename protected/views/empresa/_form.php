<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/empresa.css" media="screen, projection">
<meta charset="utf-8" />
<title>jQuery UI Dialog - Uso básico</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(function () {
    $("#dialog").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
        "Continuar": function () {
            //hacer algo antes de cerrar el dialog()
        $(this).dialog("close");
        },
        "No": function () {
            //hacer algo antes de cerrar el dialog()
        $(this).dialog("close");
        }
        }
        });
        
    $("#btn").click(function() {
        //Relizar la busqueda en la BD y luego si es necesario abrir el dialog()
        $("#dialog").dialog("open");
        $("#dialog").dialog("option", "width", 600);
        $("#dialog").dialog("option", "height", 300);
        $("#dialog").dialog("option", "resizable", false);
    } )

});
</script>

<!--<div id="dialog" title="Persona encontrada">
<p>El DNI ingresado: <?php //echo $persona{'dni'} ?> ya se encuentra en la base de datos del sistema. 
    
    
    ¿Desea continuar?
</p>
</div>

<button id="btn">Abrir Dialogo</button> !-->

<div class="form">
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


<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
            
        <h3>Datos de la empresa</h3>
        <div class="empresa">
            <div class="razonsocial">            
                <?php
                echo $form->textFieldGroup(
                        $empresa, 'razonsocial', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                    'width' => '40',
                        )
                );
                ?>
                <?php echo $form->error($empresa, 'razonsocial'); ?>
            </div>   
            <div class="cuit">
                <?php 
                echo $form->textFieldGroup(
                        $empresa, 'cuit', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                        )
                );
                ?>
                <?php echo $form->error($empresa, 'cuit'); ?>
            </div>
        </div>
        


        <h3>Datos del dueño</h3>

        <div class="persona">
                
            
            <div class="row1">
                <div class="tipodni">
                    <?php echo $form->dropDownListGroup($persona, 'tipo_dni', array ('wrapperHtmlOptions' => array( 'class' => 'col-sm-5',),'widgetOptions' => array( 
                        'data' => array('DNI', 'LE', 'LC'),'htmlOptions' => array(),) )); ?>
                </div>
                <div class="dni">            
                    <?php echo $form->textFieldGroup($persona, 'dni', array ('hint' => 'sin punto (.) ej: 23456545', 'widgetOption'  =>  'Checsdasadut', 'wrapperHtmlOptions' => array('class' => 'col-sm-5',),'width' => '40', )); ?>
                </div>
            
                
                <?php //$this->widget('booster.widgets.TbButton', array('label' => 'Validar', 'context' => 'info','buttonType' => 'submit',));?>
            
            </div>
            
     <?php if($checked){?>       
<div id="oculto">
            <div class="row2">
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
                <div class="cuil">
                        <?php echo $form->textFieldGroup($persona, 'cuil', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
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
            
        </div>
          <?php }?>
          <?php if(!$checked){?> 
            <div class="boton">
                <?php $this->widget('booster.widgets.TbButton', array('label' => 'Verificar', 'context' => 'success','buttonType' => 'submit',));?>
            </div>
          <?php }?>
            
   
        </div>
            

<?php $this->endWidget(); ?>

</div>    
    