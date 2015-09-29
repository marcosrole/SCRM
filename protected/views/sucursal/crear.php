<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
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
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array('id' => 'verticalForm',)); ?>
            <h3>Datos de la empresa</h3>
            <br>            
                <h5>Empresas asociadas:</h5>    
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
                
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $direccion, 'calle', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($direccion, 'calle'); ?>
                </div>
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $direccion, 'altura', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($direccion, 'altura'); ?>
                </div>

                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $direccion, 'piso', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($direccion, 'piso'); ?>
                </div>
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $direccion, 'depto', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($direccion, 'depto'); ?>
                </div>

                <div class="row">
                    <?php
                    echo $form->dropDownListGroup(
                            $localidad, 'id', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                        'widgetOptions' => array(
                            'data' => $lista_localidades,
                            'htmlOptions' => array(),
                        )
                            )
                    );
                    ?>
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
        
    </body>
</html>
