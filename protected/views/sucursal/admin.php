<?php
/* @var $this SucursalController */
/* @var $model Sucursal */

$this->breadcrumbs=array(
	'Sucursals'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Listar Sucursal', 'url'=>array('index')),
	array('label'=>'Crear Sucursal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('slow','swing');
	return false;
});

");
?>

<h1>Administrar Sucursals</h1>

<p>

</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
            'sucursal'=>new Sucursal(),
            'empresa'=>new Empresa(),
    )); ?>
</div><!-- search-form -->

<?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'sucursal-grid',
            'dataProvider' => $dataProvider, 
            
            'columns' => array(                                                       
                array(
                    'name' => 'cuit',
                    'header'=>'CUIT'
                ),
                array(
                    'name' => 'razonsocial',
                    'header'=>'Razon Social'
                ),                                                
                array(
                    'name' => 'nombre',
                    'header'=>'Sucursal'
                ),                 
                array(
                    'name' => 'direccion',
                    'header'=>'Direccion'
                ),
                array(
            'class'=>'CButtonColumn',
        ),
            ),

        ));
    ?> 
