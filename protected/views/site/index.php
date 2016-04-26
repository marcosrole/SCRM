<style>
    .login {
    display: -webkit-inline-box;
    margin-left: 40%;
    
}
</style>

<script>
    function verEstado(){     
//     var server = window.location.hostname;      
//     var direccion = "http://" +server+ "/SCRM/usuario";
//     
//     $.get("http://http://localhost/SCRM/alarma/admin");
  }
$(document).ready(function() {
       //setInterval(verEstado, 2000); 
       alert("1");
       $.ajax({
        url: 'C:\wamp\www\SCRM\protected\views\usuario\hello.php',
        success: function (response) {//response is value returned from php (for your example it's "bye bye"
          alert(response);
        }
     });
  });
</script>

NUMERO:<div id="d1"></div>
    
<?php
$this->widget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'Sistema de Control de Ruidos Molestos',
        'encodeHeading'=>'true',
        'htmlOptions' => array(),
        'headingOptions'=> array(),
    )
);
?>

 <?php $this->renderPartial(
                        '_form',
                        array(
                            'usuario'=>$usuario,
                            'error'=>$error,
                        )); ?>



