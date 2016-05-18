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
/* @var $this UsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuarios',
);

$this->menu=array(
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Modificar Usuario', 'url'=>array('admin')),
);
?>
<?php



Yii::app()->clientScript->registerScript('dropdown', '
   $("#Rol_id").change(function() {
      var id = $("#Rol_id").find("option:selected").attr("value"); 
      var server = window.location.hostname;      
      var direccion = "http://" +server+ "/SCRM/usuario/index/rol/" + id;
      window.location=direccion;      
      $("#show_dropdown_content").text(direccion);      
   });
   
    myDivObj = document.getElementById("myDiv");
    if ( myDivObj ){
    			if ( myDivObj.textContent ){ // FF
    				//alert ( myDivObj.textContent );
                                $("#usuarios").toggle();
    			}else{	// IE			
    				//alert ( myDivObj.innerText );  //alert ( divObj.innerHTML );
    			} 
    		} 

');


?>

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
                
            ),
        ));
?>

<h1>Usuarios</h1>



<?php    $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            array(
                'id' => 'verticalForm',
                'htmlOptions' => array('class' => 'well'), // for inset effect
            ));?>

            <?php echo $form->dropDownListGroup(
                        $rol,
                        'id',
                        array(
                            'id'=>'dropdown',
                            'wrapperHtmlOptions' => array(
                                    'class' => 'col-sm-5',
                            ),
                            'widgetOptions' => array(
                                    'data' => $roles,
                                    'htmlOptions' => array('prompt'=>'--Seleccionar tipo de usuario--'),
                            )
                        ),
                        array(
                            'options' => array('5'=>array('selected'=>true)),
                        )
                ); 
            ?>
                <h4><strong>
                    <div id="myDiv"><?php echo $DataProviderUsuario->getData()[0]['roles']; ?></div>
                </strong></h4>
            
            
            <div id="usuarios" style="display: none" >
                <?php 
                    $this->widget('booster.widgets.TbGridView', array(
                        'id' => 'sucursal-grid',
                        'dataProvider' => $DataProviderUsuario,                        
                        'columns' => array(                                                       
                            array(
                                'name' => 'name',
                                'header'=>'Usuario',                                
                            ),
                            array(
                                'name' => 'nombre',
                                'header'=>'Nombre',                                
                            ),
                            array(
                                'name' => 'apellido',
                                'header'=>'Appelido',                                
                            ),
                            
                            array(
                                'class' => 'booster.widgets.TbButtonColumn',
                               // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                                'template' => '{permisos}   {semanasLaborales} ', // botones a mostrar
                                'buttons' => array(
                                    'semanasLaborales' => array
                                    (
                                        'label'=>'Dias Laborales',
                                        'icon'=>'glyphicon glyphicon-calendar',                                                                               
                                        'url'=> 'Yii::app()->createUrl("semanatrabajo/view", array("id_usr"=> ' . '$data["id"])) ',
                                    ),                                                            
                                    'permisos' => array
                                    (
                                        'label'=>'Permisos en el Sistema',
                                        'icon'=>'glyphicon glyphicon-wrench',                                                                               
                                        'url'=> 'Yii::app()->createUrl("nivelesmenu/create", array("id_usr"=> ' . '$data["id"])) ',
                                    ),                                                            
                                ),
                                //'htmlOptions'=>array('style'=>'width: 120px'),
                                ),
                            
                        ),

                    ));
                ?> 

            </div>
                

                <?php 
                $this->endWidget();?>

