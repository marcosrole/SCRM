<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */

//$this->breadcrumbs=array(
//	'Permisosusuarios'=>array('index'),
//	$model->id,
//);

$this->menu=array(
	array('label'=>'Asignar Permisos', 'url'=>array('permisosusuario/view')),
	array('label'=>'Crear Usuario', 'url'=>array('usuario/create')),
//	array('label'=>'Update Permisosusuario', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Permisosusuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Permisosusuario', 'url'=>array('admin')),
);
?>

<h1>Accesos disponibles</h1>

<?php
$this->widget('booster.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $datos,       
        'filter' => $permiso,
         'columns' => array(
                array(
                    'name' => 'id',
                    'header'=>'ID'
                ),
                array(
                    'name' => 'titulo',
                    'header'=>'Titulo'
                ),
                array(
                    'name' => 'descripcion',
                    'header'=>'Descripcion'
                ),                
             ),
    ));
        
?>