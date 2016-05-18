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
<?php
/* @var $this AsignarinspectorController */
/* @var $model Asignarinspector */

$this->breadcrumbs=array(
	'Asignarinspectors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Asignaciones', 'url'=>array('index')),
	array('label'=>'Crear Asignacion', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('#search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#asignarinspector-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Eliminar Asignaciones</h1>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'AsignarInspector',
                )); ?>

<?php
$this->widget('booster.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $dataProvider,    
         'columns' => array(                
                             
             array(
                    'name' => 'nombre_suc',
                    'header'=>'Sucursal'
                ),             
             array(
                    'name' => 'nombre_emp',
                    'header'=>'Empresa'
                ),      
                          
             array(
                    'name' => 'inspector',
                    'header'=>'Inspector'
                ),  
             array(
                    'name' => 'fechahsIns',
                    'header'=>'Asignacion'
                ),
            array(
                    'header' => "",
                    'id' => 'selectDeleteInspectores',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 100, //Numero de filas que se pueden seleccionar
                ),
            ),
    ));
        
?>
<p>
    
</p>
    <div class="boton">
        <?php $this->widget('booster.widgets.TbButton', array('label' => 'Eliminar','context' => 'error','buttonType'=>'submit',)); ?>        
    </div>

    <?php $this->endWidget(); ?>