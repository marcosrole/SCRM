<?php
/* @var $this SucursalController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Sucursals',
);

$this->menu=array(
	array('label'=>'Crear Sucursal', 'url'=>array('create')),
	array('label'=>'Administrar Sucursal', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('dropdown', '
   $("#Gruposucursal_id").change(function() {
      var content = $("#Gruposucursal_id option:selected").text();      
      var direccion = "http://localhost/SCRM/sucursal/indexzona/zona/" + content;
      window.location=direccion;      
      
   });
');
?>
<script type="text/javascript">  
function ocultarZona(){  
      if ( (document.forms[0].optionsRadios[1].checked == true ) )  
        {  
            document.getElementById('SucursalTodos').style.display = 'none';  
            document.getElementById('zona').style.display = 'block';  
        }  
      if ( (document.forms[0].optionsRadios[0].checked == true ) )  
        {  
            document.getElementById('zona').style.display = 'none';  
            document.getElementById('SucursalTodos').style.display = 'block';  
        }
      if ( (document.forms[0].optionsRadios[2].checked == true ) )  
        {  
            var direccion = "http://localhost/SCRM/empresa/list";
            document.getElementById('SucursalTodos').style.display = 'block';  
            window.location=direccion;      
        }
    }    
    
   
   

    
    
</script>  
<?php
Yii::app()->clientScript->registerScript('dropdown', '
   $("#Zona_id").change(function() {         
      var id = $("#Zona_id").find("option:selected").attr("value");      
      var server = window.location.hostname;      
      var direccion = "http://" +server+ "/SCRM/sucursal/index/id_zon/" + id;
      window.location=direccion;            
   });
');

?>


<h1>Sucursals</h1>
  
        
<form name="Form1" action="#" >  
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" onclick = "ocultarZona()">
            Mostrar todos
          </label>
        </div> 
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" onclick = "ocultarZona()">
            Mostrar por zona
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" onclick = "ocultarZona()">
            Mostrar por empresa
          </label>
        </div>
</form> 

<div id='zona' style='display:none;'>
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                'id' => 'UsuarioForm',
                'htmlOptions' => array('class' => 'well'), )); ?>
    
            <?php echo $form->dropDownListGroup($zona,'id',array('id'=>'dropdown','wrapperHtmlOptions' => array('class' => 'col-sm-5',),
                        'widgetOptions' => array(
                                'data' => $listZona,
                                'htmlOptions' => array('prompt'=>'--Seleccionar zona--'),
                        )
                    ),
                    array(
                        'options' => array('5'=>array('selected'=>true)),
                    )
            ); ?>
    
    <?php $this->endWidget();?>
</div>

<div id="SucursalTodos">
    <?php            
            $this->widget('booster.widgets.TbGridView', array(
            'id' => 'dispositivo-grid-list',
            'dataProvider' => $DataProviderSucursales,
             'columns' => array(                                                
                            array(
                                'name' => 'nombre',
                                'header'=>'Sucursal',                                    
                            ),
                            array(
                                'name' => 'empresa',
                                'header'=>'Empresa',                                    
                            ),                        
                            array(
                                'name' => 'direccion',
                                'header'=>'Direccion',                                    
                            ),
                            array(
                                'name' => 'localidad',
                                'header'=>'Localidad',                                    
                            ),
                            array(
                                'name' => 'zona',
                                'header'=>'Zona',                                    
                            ),                            
                        ),
            ));
        ?>

</div>
