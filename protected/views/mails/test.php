<style>
    h1   {
        color:blue;                   
    }
    nota{
        color: red;
    }
</style>
   

<h1>
    Sistema de Control de Ruidos Molestos
</h1>    


<p class="nota"> 
    <strong>
        Se ha generado una alarma desde el Sistema.
    </strong>
</p>

<?php $this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $datos,
        'attributes' => array(            
            array('name' => 'descripcion', 'label' => 'Descripcion'),
            array('name' => 'vesperado', 'label' => 'Valor Esperado'),
            array('name' => 'vactual', 'label' => 'Valor Actual'),
            array('name' => 'sucursal', 'label' => 'Sucursal'),
            array('name' => 'empresa', 'label' => 'Empresa'),
            array('name' => 'direccion', 'label' => 'Direccion'),
            array('name' => 'fecha', 'label' => 'Fecha'),
            array('name' => 'hs', 'label' => 'HS'),
        ),
        )
    );
?>

<address>
    <br>Por favor trate de solucionar el inconveniente lo antes posible.<br>
    Muchas Gracias.<br>
</address>
    
<br>
<br>
<address>
  <strong>Sistema de Control de Ruidos Molestos.</strong><br>
  San Martin 3134<br>
  Santa Fe, CP: 3000<br>
  <abbr title="Phone">Cel:</abbr> (123) 456-7890
</address>

<address>
  <strong>Role Marcos</strong><br>
  <a href="mailto:#">marcosrole@gmail.com</a>
</address>