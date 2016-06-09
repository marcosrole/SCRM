<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */

$this->breadcrumbs=array(
	'Permisosusuarios'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Permisosusuario', 'url'=>array('index')),
	array('label'=>'Create Permisosusuario', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#permisosusuario-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Permisosusuarios</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'permisosusuario-grid',
	'dataProvider'=>$model->search(),
     'summaryText'=>'Página {page}-{pages} de {count} resultados.',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_usr',
		'id_per',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
