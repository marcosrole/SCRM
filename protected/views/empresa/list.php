<div class="form">    
    <?php $form= $this->beginWidget('booster.widgets.TbActiveForm',array('id' => 'verticalForm',)); ?>            
    <div class="campo">
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
                            'class' => 'booster.widgets.TbEditableColumn',
                            'name' => 'dni_per',
                            //'htmlOptions'=>array('width'=>'150'),                            
                            'editable' => array(
                                'type' => 'number',
                                'url'=> Yii::app()->createUrl("/empresa/editable"),                                                                                                      
                                'placement' => 'right',
                                'inputclass' => 'span3',
                                //'type' => 'select',
                                //($model->availableStreets($data->id), 'id', 'street'),                                 
                                //ver: http://www.yiiframework.com/wiki/48/by-example-chtml/#hh4
                                
                                //'placement' => 'right',
                            ),                            
                        ),              
                    ),                    
                ));                
            ?> 
    </div>    
        <?php $this->endWidget(); ?>
    
  <?php   
  /*  $this->widget(
    'booster.widgets.TbEditableField',
    array(
        'type' => 'text',
        'model' => $empresa,
        'name' => 'dni_per',
        'mode' => 'inline',
        'text' => 'Editar texto',        
        'attribute' => 'dni_per', // $model->name will be editable
        'url'=> Yii::app()->createUrl('Empresa/Editable'),  
        )
    );*/
    ?>
        
    </div>
