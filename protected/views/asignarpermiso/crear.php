<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('dropdown', '
   $("#Asignarpermiso_id_usr").change(function() {
      var content = $("#Asignarpermiso_id_usr option:selected").text();      
      var direccion = "http://localhost/SCRM/asignarpermiso/crear/name/" + content;
      window.location=direccion;      
      $("#show_dropdown_content").text("You have selected: "+content);
   });
');
?>

<?php
/* @var $this AsignarpermisoController */

$this->breadcrumbs=array(
	'Asignarpermiso'=>array('/asignarpermiso'),
	'Crear',
);
?>
<div id="show_dropdown_content"></div>

<h1>Permisos de usuario</h1>
<script> 
    
$(function() {
  enable_cb();
  $("#buttonHabilitar").click(enable_cb);
});

function enable_cb() {
    if($("input.group1").prop( "checked" )){
        "Marcos";
    }
    
//  if (this.checked) {
//    $("input.group1").prop("disabled", true);
//  } else {
//    $("input.group1").prop("disabled", false);
//  }
}
</script>

<?php
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
        'htmlOptions' => array('class' => 'well'), // for inset effect
    )
);?>
        <?php echo $form->dropDownListGroup(
                $asignarpermiso,
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
                $asignarpermiso,
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


<form name="frmChkForm" id="frmChkForm">
<input type="checkbox" name="chkcc9" id="group1">Check Me
<input type="checkbox" name="chk9[120]" class="group1">
<input type="checkbox" name="chk9[140]" class="group1">
<input type="checkbox" name="chk9[150]" class="group1">
</form>
