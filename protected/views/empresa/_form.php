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
 

 <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'focus'=>array($empresa,'razonsocial'),
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
       
            
        <div class="boton">
                <?php $this->widget('booster.widgets.TbButton', array('label' => 'Cargar', 'context' => 'success','buttonType' => 'submit',));?>
            </div>
<?php $this->endWidget(); ?>

</div>    
    