<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/usuario.css" media="screen, projection">
<?php
/* @var $this SucursalController */
/* @var $model Sucursal */
/* @var $form CActiveForm */
?>

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
                                'filter' => $empresa,
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
                                        'selectableRows' => 1, //Numero de filas que se pueden seleccionar
                                    ),                        
                                ),

                            ));

                        ?>                    
                </div>
                <p>
                    <br>
                    
                    
                    
                </p>
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $sucursal, 'nombre', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($sucursal, 'nombre'); ?>
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