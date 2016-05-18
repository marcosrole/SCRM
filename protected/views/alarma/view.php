<?php $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos,
        'attributes' => array(
//            array('name' => 'id', 'label' => 'ID Alarma'),
            array('name' => 'descripcion', 'label' => 'Causa de Alarma'),
            array('name' => 'sucursal', 'label' => 'Sucursal'),
            array('name' => 'empresa', 'label' => 'Empresa'),
            array('name' => 'direccion', 'label' => 'Direccion'),
            array('name' => 'fecha', 'label' => 'Fecha'),
            array('name' => 'hs', 'label' => 'HS'),
        ),
        )
    );
?>
                      