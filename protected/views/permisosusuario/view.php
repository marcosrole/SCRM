<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */

$this->breadcrumbs=array(
	'Permisosusuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Accesos disponibles', 'url'=>array('permiso/list')),
	array('label'=>'Administrar Permiso', 'url'=>array('admin')),
);
?>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('dropdown', '
   $("#Permisosusuario_id_usr").change(function() {
      var content = $("#Permisosusuario_id_usr option:selected").text();      
      var direccion = "http://localhost/SCRM/permisosusuario/crear/name/" + content;
      window.location=direccion;      
      $("#show_dropdown_content").text("You have selected: "+content);
   });
');
?>
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
<h1>Permisos de usuario</h1>
<div class="form">
    <?php
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
        'htmlOptions' => array('class' => 'well'), // for inset effect
    ));?>
        <?php echo $form->dropDownListGroup(
                $permisosUsuario,
                'id_usr',
                array(
                    'id'=>'dropdown',
                    'wrapperHtmlOptions' => array(
                            'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                            'data' => $array_usuarios,
                            //'htmlOptions' => array('prompt'=>'--Seleccionar--'),
                    )
                ),
                array(
                    'options' => array('5'=>array('selected'=>true)),
                )
        ); ?>

        
        <?php echo $form->checkboxListGroup(
                $permisosUsuario,
                'id_per',
                array(
                        'widgetOptions' => array(
                                'data' => $array_permiso,
                                'disabled'=>'disabled',
                        ),
                        'hint' => '<strong>Note:</strong> Seleccione todos los permisos para el usuario.'
                )
        ); ?>

        <?php
        $form->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Asignar',
                'context' => 'success',
                 'buttonType'=>'submit',
            )
        );
        ?>

<?php 
$this->endWidget();
unset($form);
?>

</div>
