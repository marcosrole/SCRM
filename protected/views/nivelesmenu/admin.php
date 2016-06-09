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


/* @var $this NivelesmenuController */
/* @var $model Nivelesmenu */

$this->breadcrumbs=array(
	'Nivelesmenus'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=>'Listar usuarios', 'url'=>array('usuario/index')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nivelesmenu-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('dropdown', '
   $("#Nivelacceso_id").change(function() {      
      var id = $("#Nivelacceso_id").find("option:selected").attr("value");      
      var server = window.location.hostname;      
      var direccion = "http://" +server+ "/SCRM/nivelesmenu/admin/id_nivacc/" + id;
      window.location=direccion;      
      $("#show_dropdown_content").text(direccion);
   });
');

?>

<h1>Administrar menues</h1>

<p>
Asignar para cada nivel de acceso su correspondiente menu
</p>


<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
        'id' => 'UsuarioForm',
        'htmlOptions' => array('class' => 'well'), )); ?>
        
        <div class="sexo">
            <?php echo $form->dropDownListGroup(
                        $NivelesAcceso,
                        'id',
                        array(
                            'id'=>'dropdown',
                            'wrapperHtmlOptions' => array(
                                    'class' => 'col-sm-5',
                            ),
                            'widgetOptions' => array(
                                    'data' => $ListNivelesAcceso,
                                    'htmlOptions' => array('prompt'=>$NivAccSeleccionado),
                            )
                        ),
                    
                        array(
                            //'options' => array('5'=>array('selected'=>true)),
                        )
                ); 
            ?>
        </div>
        <?php
            
            $MenuSelecionado ='[' . implode(',',$MenuSelecionado) . ']';
            $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
           
//                'template'=>'{summary}{items}{pager}',
             'enablePagination' => true,
             'summaryText'=>'Página {page}-{pages} de {count} resultados.',
            'enableSorting'=>true,
            'dataProvider' => $ListMenu,
             'columns' => array(                                                
                            array(
                                'name' => 'menu',
                                'header'=>'Menu',                                    
                            ),
                            array(
                                'name' => 'submenu',
                                'header'=>'Submenu',                                    
                            ), 
                            array(
                                'name' => 'descripcion',
                                'header'=>'Descripcion',                                    
                            ), 
                            array(
                                
                                'header' => "",
                                'id' => 'selectNivelAcceso',
                                'class' => 'CCheckBoxColumn',                                
                                'checked'=>'in_array($data["id"], '  . $MenuSelecionado .  '  )',
                                'selectableRows' => 1000, //Numero de filas que se pueden seleccionar
                            ),                        
                        ),
            ));
        ?>
        <div class="boton">
            <?php $this->widget('booster.widgets.TbButton', array('label' => 'Asignar', 'context' => 'success','buttonType' => 'submit',));?>
        </div>
    
<?php $this->endWidget(); ?>





