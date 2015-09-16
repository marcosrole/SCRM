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
        $this->breadcrumbs=array(
	'Usuario'=>array('/usuario'),
	'Crear',
        );
        ?>
        
        <h1>Añadir Usuario</h1>
        
        <div class="form">    
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array('id' => 'verticalForm',)); ?>
            <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $usuario, 'name', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($usuario, 'name'); ?>
            </div>
            <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $usuario, 'pass', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($usuario, 'pass'); ?>
                </div>            
            

             <div class="row">

                        <?php echo $form->dropDownListGroup(
                                $persona,
                                'tipo_dni',
                                array(
                                        'wrapperHtmlOptions' => array(
                                                'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                                'data' => array('DNI','LE','LC'),
                                                'htmlOptions' => array(),
                                        )
                                )
                        ); ?>
                        <?php echo $form->error($persona,'tipo_dni'); ?>
                </div>

            <div class="row">            
                <?php
                echo $form->textFieldGroup(
                        $persona, 'dni', array(
                            'hint' => 'Check keyboard layout',
                            'widgetOption' => 'Checsdasadut',      


                         'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                    'width' => '40',
                        )
                );
                ?>
                <?php echo $form->error($persona, 'dni'); ?>
            </div> 

            <div class="row">
                <?php
                echo $form->textFieldGroup(
                        $persona, 'nom_ape', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                        )
                );
                ?>
                <?php echo $form->error($persona, 'nom_ape'); ?>
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
                <?php echo $form->dropDownListGroup(
                                $localidad,
                                'id',
                                array(
                                        'wrapperHtmlOptions' => array(
                                                'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                                'data' => $lista_localidades,
                                                'htmlOptions' => array(),
                                        )
                                )
                        ); ?>
                        <?php echo $form->error($localidad,'id'); ?>

            </div>
            <div class="row">
                <?php echo $form->dropDownListGroup(
                                $persona,
                                'sexo',
                                array(

                                        'wrapperHtmlOptions' => array(
                                                'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                                'data' => array('M','F'),
                                                'htmlOptions' => array(),
                                        )
                                )
                        ); ?>
                        <?php echo $form->error($persona,'tipo_dni'); ?>
            </div>
                
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $persona, 'cuil', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($persona, 'cuil'); ?>
                </div>
        
                <div class="row">
                    <?php
                    echo $form->textFieldGroup(
                            $persona, 'telefono', array(
                        'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($persona, 'telefono'); ?>
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
