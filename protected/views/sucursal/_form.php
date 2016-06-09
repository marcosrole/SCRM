<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/usuario.css" media="screen, projection">


<?php
/* @var $this SucursalController */
/* @var $model Sucursal */
/* @var $form CActiveForm */
?>
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
 <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
        <div class="form">    
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
            
            <br>            
                <h3>Empresas asociadas:</h3>    
                <div class="campo">
                    <?php 
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => 'empresasAsociadas',
                                'dataProvider' => $empresa->search(),
                                  'summaryText'=>'Página {page}-{pages} de {count} resultados.',
                                'columns' => array(                        
                                    array(
                                        'name' => 'cuit',
                                        'header'=>'CUIT'
                                    ),
                                    array(
                                        'name' => 'razonsocial',
                                        'header'=>'Razon Social',                                                        
                                    ),
                                     array(
                                        'header' => "",
                                        'id' => 'selectEmpresa',
                                        'class' => 'CCheckBoxColumn',
                                         'checked'=>'in_array($data->cuit, '  . $EmpresaSeleccionada .  '  )',
//                                        'checked'=>'in_array($data->cuit, [45784521]  )',
                                        'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                                    ),                        
                                ),

                            ));

                        ?>                    
                </div>
                <p>
                    <br>
                    
                    
                    
                </p>
                <div class="sucursal">
                    <div class="nombre-sucursal">
                        <?php echo $form->textFieldGroup($sucursal, 'nombre', array('style' => 'text-transform: uppercase','wrapperHtmlOptions' => array('class' => 'col-sm-5', ),)); ?>
                    </div>           

                    <div class="zona-sucursal">
                        
                        <?php echo $form->dropDownListGroup($zona,'id',array('id'=>'dropdown','wrapperHtmlOptions' => array('class' => 'col-sm-5',),
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
                
                
                 <div class="persona">
                     <h3>Resposnable: </h3>
            
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