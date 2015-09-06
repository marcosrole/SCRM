<?php


$this->breadcrumbs=array(
	'Detalle Dispos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cargar Detalles', 'url'=>array('DetalleDispo/create')),
	array('label'=>'Administrar Dispositivos', 'url'=>array('Dispositivo/admin')),
);
?>

<?php
if($datos_guardados){
    echo "Datos guardados con exito";    
}
?>

<h1>Nuevo Dispositivo</h1>

<div class="form">    
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array('id' => 'verticalForm',)); ?>
    <h3>Datos de la empresa</h3>
    <div class="row">            
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


    <div class="row">
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
			'id_loc',
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
                <?php echo $form->error($localidad,'id_loc'); ?>
    
    </div>
   
    <h3>Datos del dueño</h3>
    
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
