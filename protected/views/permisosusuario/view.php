<?php
/* @var $this PermisosusuarioController */
/* @var $model Permisosusuario */


$this->menu=array(
//	array('label'=>'List Permisosusuario', 'url'=>array('index')),
//	array('label'=>'Create Permisosusuario', 'url'=>array('create')),
//	array('label'=>'Update Permisosusuario', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Permisosusuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Permisosusuario', 'url'=>array('admin')),
);
?>

<h1>Permisos del usuario #<?php echo $permisosUsuario->id_usr; ?></h1>

<?php
$this->widget('booster.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $permisosUsuario->search(),        
        
         'columns' => array(
                array(
                    'name' => 'id',
                    'header'=>'#'
                ),
                array(
                    'name' => 'name',
                    'header'=>'Nombre'
                ),
                array(
                    'name' => 'pass',
                    'header'=>'Contraseña'
                ),                
                array(
                    'name' => 'nivel',
                    'header'=>'Nivel de Acceso'
                ),             
             array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{delete} {update}', // botones a mostrar
                    'buttons' => array(
                        'delete' => array(
                            'label' => 'Detalles',                                                         
                            'url'=> 'Yii::app()->createUrl("/Calibracion/view?id=$data->id")'
                        ),                        
                        'update' => array(
                            'label' => 'Actualizar',                                                         
                            'url'=> 'Yii::app()->createUrl("/usuario/update?id=$data->id")'
                        ),                
                    ),
                    //'htmlOptions'=>array('style'=>'width: 120px'),
                    ),
             ),
    ));
        
?>
