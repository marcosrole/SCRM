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
<h2>Empresa:</h2>
<?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'sucursal-grid',
            'dataProvider' => $empresa->search(), 
             'summaryText'=>'Página {page}-{pages} de {count} resultados.',
            'columns' => array(                                                       
                
                array(
                    'name' => 'razonsocial',
                    'header'=>'Razon Social',
                    'htmlOptions'=>array('width'=>'3O%'), 
                ),                                                
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{view} ', // botones a mostrar
                    'buttons' => array(
                        'view' => array(
                            'label' => 'Ver sucursales',                                                         
                            'icon' => 'glyphicon glyphicon-ok',
                            'url'=> 'Yii::app()->createUrl("sucursal/admin?cuit=$data->cuit")'
                        ),                          
                    ),
                    'htmlOptions'=>array('width'=>'4O%'), 
                    ),                           
            ),
              
        ));
    ?> 


<?php 

if($sucursal_visible){ ?>

<h3>Empresa seleccionada: <?php echo $empresa_seleccionada{'razonsocial'}; ?></h3>
    <?php
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'sucursal-grid',
            'dataProvider' => $data, 
             'summaryText'=>'Página {page}-{pages} de {count} resultados.',
            'columns' => array(                                                       
                array(
                    'name' => 'nombre',
                    'header'=>'Nombre',
                    'htmlOptions'=>array('width'=>'80%'), 
                ), 
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{view}  {update}  {delete}', // botones a mostrar
                    'buttons' => array(
                        'view' => array(
                            'label' => 'Detalles',                                                         
                            'url'=> 'Yii::app()->createUrl("sucursal/view?id=$data->id")'
                        ),  
                        'delete' => array
                        (
                            'label'=>'Eliminar',
                            'icon'=>'glyphicon glyphicon-trash',

                            'click' => 'function(){return confirm("Desea eliminar la sucursal?");}',
                            'url'=> 'Yii::app()->createUrl("sucursal/delete?id=$data->id")',                                                    
                            
                        ),                        
                        'update' => array(
                            'label' => 'Actualizar',                                                         
                            'url'=> 'Yii::app()->createUrl("sucursal/update?id=$data->id")'
                        ),
                    ),
                    'htmlOptions'=>array('width'=>'20%'), 
                    ),  
                ),
        ));
}
    ?> 
