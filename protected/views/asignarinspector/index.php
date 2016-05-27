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



<style>
p {
    background-color: #0099FF;
}

</style>
<?php
/* @var $this AsignarinspectorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asignarinspectors',
);

$this->menu=array(
	array('label'=>'Crear Asignacion', 'url'=>array('create')),
	array('label'=>'Eliminar Asignaciones', 'url'=>array('admin')),
);
?>

<h1>Asignaciones Realizadas</h1>

<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); $cont=0;?>
<div class="panel-group" id="accordion">
    
    <?php foreach ($datos as $dato){ $cont++;?>
    
        <?php $id='item' . $cont; ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $id; ?>">
                  <?php echo $dato{'inspector'}; ?> - <samp><?php echo $dato{'nombre_suc'}; ?>.</samp> Fecha: <?php echo $dato{'fechahsIns'}; ?>
              </a>
            </h4>
          </div>
          <div id="<?php echo $id; ?>" class="panel-collapse collapse ">
            <div class="panel-body">
              <?php $this->widget(
                'booster.widgets.TbDetailView',
                array(
                    'data' => $dato,
                    'attributes' => array(
                        array('name' => 'encargado', 'label' => 'Responsable de la sucursal'),
                        array('name' => 'fechahsDue', 'label' => 'Horario de aviso al Responsable'),
                        array('name' => 'inspector', 'label' => 'Inspector responsable'),            
                        array('name' => 'fechahsIns', 'label' => 'Horario de aviso al Inspector'),            
                        array('name' => 'alarma', 'label' => 'Alarma generada'),
                        array('name' => 'nombre_emp', 'label' => 'Empresa'),
                        array('name' => 'nombre_suc', 'label' => 'Sucursal'),
                        array('name' => 'direccion', 'label' => 'Direccion'),
                    ),
                    )
                ); ?>
            </div>
          </div>
        </div>  
    
    <?php }?>
</div>
<?php $this->endWidget(); ?>