<?php
/* @var $this HistoasignacionController */
/* @var $model Histoasignacion */

$this->breadcrumbs=array(
	'Histoasignacions'=>array('index'),
	
);

$this->menu=array(
	array('label'=>'List Histoasignacion', 'url'=>array('index')),
	array('label'=>'Create Histoasignacion', 'url'=>array('create')),
//	array('label'=>'Update Histoasignacion', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Histoasignacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Histoasignacion', 'url'=>array('admin')),
);
?>

<h1>Empresa: <?php echo $empresa{'razonsocial'}; ?></h1>


<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => $sucursal{'nombre'},
        'headerIcon' => 'th-list',
    	'padContent' => false,
        'htmlOptions' => array('class' => 'bootstrap-widget-table')
    )
);?>
    
    <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'empresasAsociadas',
                    'dataProvider' => $DataProviderDispositivos, 
                    'summaryText' => '',
                    'columns' => array(                        
                        array(
                                'name' => 'dispositivo',
                                'header'=>'Dispositivo',                                    
                            ),
                            array(
                                'name' => 'fechaAlta',
                                'header'=>'Fecha de Alta',                                    
                            ),                                                                          
                    ),
                    
                ));
                
            ?>  
<?php $this->endWidget(); ?>



