<?php
/* @var $this EmpresaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Empresas',
);

$this->menu=array(
	array('label'=>'Create Empresa', 'url'=>array('create')),
	array('label'=>'Administrar Empresa', 'url'=>array('admin')),
        array('label'=>'Listar Sucursales', 'url'=>array('sucursal/index')),
);
?>

<h1>Empresas</h1>

<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>            
    <div class="campo">
        <?php $empresa = new Empresa(); ?>
        <?php 
                $this->widget('booster.widgets.TbGridView', array(
                    'id' => 'dispositivo-grid-list',
                    'dataProvider' => $empresa->search(),
                    'filter' => $empresa,
                    'columns' => array(                        
                        array(
                            'name' => 'cuit',
                            'header'=>'CUIT',                                                       
                        ),
                        array(
                            'name' => 'razonsocial',
                            'header'=>'Razon Social'
                        ),
                        array(
                            'class' => 'booster.widgets.TbButtonColumn',
                            'template'=> '{sucursal}',
                            'buttons'=>array
                                (
                                    'sucursal' => array(
                                    'label'=>'Sucursal',
                                    'icon'=>'glyphicon glyphicon-list-alt',
                                    'url'=>'Yii::app()->createUrl("empresa/view", array("cuit"=>$data->cuit))',                                    
                                ), 
                            ),             
                             'htmlOptions'=>array('style'=>'width: 140px'),
                        ), 
                        
                    ),                    
                ));                
            ?> 
    </div>    
 <?php $this->endWidget(); ?>
</div>
