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
/* @var $this DetalleDispoController */
/* @var $model DetalleDispo */

$this->breadcrumbs=array(
	'Detalle Dispos'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List DetalleDispo', 'url'=>array('index')),
//	array('label'=>'Manage DetalleDispo', 'url'=>array('admin')),
);
?>


<div id="browse_app">
  <a class="btn btn-large btn-info" href="http://localhost/SCRM/DetalleDispo/create/358/62/1/2015-03-22/2:00:00">Generar Registro</a> 
http://localhost/SCRM/DetalleDispo/create/358/62/1/2015-03-22/2:00:00
</div>
