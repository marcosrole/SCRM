<?php
/* @var $this SemanatrabajoController */
/* @var $model Semanatrabajo */

$this->breadcrumbs=array(
	'Semanatrabajos'=>array('index'),
//	$model->id,
);

$this->menu=array(
        array('label'=>'Agregar Dias Laborales', 'url'=>array('create', 'id_usr'=>$usuario->id)),
	array('label'=>'Listar Usuarios', 'url'=>array('usuario/index')),	
        array('label'=>'Administrar Dias Laborales', 'url'=>array('admin', 'id_usr'=>$usuario->id)),
	
);
?>

<h4>Usuario: </h4>
<h4>Nombre: <?php echo $usuario{'nombre'}; ?></h4>
<h4>Apellido: <?php echo $usuario{'apellido'}; ?></h4>

<?php 
        $this->widget('booster.widgets.TbGridView', array(
            'id' => 'sucursal-grid',
            'dataProvider' => $DataProviderSemanas,            
            'columns' => array(                                                       
                array(
                    'name' => 'nrosemana',
                    'header'=>'Semana',                    
                ),                                           
                array(
                    'name' => 'lun',
                    'header'=>'Lun',  
                    'value'=>'$data["lun"] == 1 ? "Si" : " " ',
                ),                       
                array(
                    'name' => 'mar',
                    'header'=>'Mar',                    
                    'value'=>'$data["mar"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'mie',
                    'header'=>'Mie',    
                    'value'=>'$data["mie"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'jue',
                    'header'=>'Jue',    
                    'value'=>'$data["jue"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'vie',
                    'header'=>'Vie',    
                    'value'=>'$data["vie"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'sab',
                    'header'=>'Sab',    
                    'value'=>'$data["sab"] == 1 ? "Si" : " "',
                ),                       
                array(
                    'name' => 'dom',
                    'header'=>'Dom',    
                    'value'=>'$data["dom"]== 1 ? "Si" : " "',
                ),                                       
                array(
                    'name' => 'hsdesde',
                    'header'=>'Desde',    
                  
                ),
                array(
                    'name' => 'hshasta',
                    'header'=>'Hasta',    
                  
                ),
               
            ),
              
        ));
    ?> 
