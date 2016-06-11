<style>
    .dropdown-submenu {
    position: relative;
}
 
.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}
 
.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}
 
.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}
 
.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}
 
.dropdown-submenu.pull-left {
    float: none;
}
 
.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
</style>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
       
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icono.png" type="image/x-icon" /> 
        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div id="alarma"> </div>
        <div id="PREalarma"> </div>
        <?php 
//        $self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
//        header("refresh:2; url=$self"); //Refrescamos cada 10 segundos
        
        
        $usuario = new Usuario();
        $usuario=Usuario::model()->find();
        
        ob_start(); ?>
         <div id="alarma"> </div>
        <?php $alarmas = ob_get_contents();
        
        $PREalarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'1'));
        $alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'0'));
        $asiganciones = Asignarinspector::model()->findAllByAttributes(array('finalizado'=>'0'));
        ?>
      <script type="text/javascript">
          $(document).ready(function(){
                    setInterval(alertFunc, 3000);
                    setInterval(asignarInspector, 3000);
//                      setInterval(contarAlarmas, 3000);
//                      setInterval(contarPREAlarmas, 3000);
//                      setInterval(asignarCantAlarmas, 3500);
            });
            function alertFunc() {
                $.ajax({
                    type: "POST",
                    url:    '<?php echo Yii::app()->createUrl('DetalleDispo/ValidarEstado'); ?>',
//                    data:  {val1:1,val2:2},
                    
                    complete: function(msg){                 
                         
                        },
                    error: function(xhr){
//                    alert("failure"+xhr.readyState+this.url)

                    }
                  });                
            }
            function asignarInspector() {
                $.ajax({
                    type: "POST",
                    url:    '<?php echo Yii::app()->createUrl('alarma/AsignarInspector'); ?>',
//                    data:  {val1:1,val2:2},
                    
                    complete: function(msg){                 
                         
                        },
                    error: function(xhr){
//                    alert("failure"+xhr.readyState+this.url)

                    }
                  });                
            }
            
            function contarAlarmas() {
                $.ajax({
                    type: "POST",
                    url:    '<?php echo Yii::app()->createUrl('site/ContarAlarmas'); ?>',
//                    data:  {val1:1,val2:2},
                    
                    success: function(resp){
                         $("#alarma").text(resp);                         
                        },
                    error: function(xhr){
//                    alert("failure"+xhr.readyState+this.url)
                    }
                  });
                
            }
            function contarPREAlarmas() {
                $.ajax({
                    type: "POST",
                    url:    '<?php echo Yii::app()->createUrl('site/ContarPREAlarmas'); ?>',
//                    data:  {val1:1,val2:2},
                    
                    success: function(resp){
                         $("#PREalarma").text(resp);                         
                        },
                    error: function(xhr){
//                    alert("failure"+xhr.readyState+this.url)
                    }
                  });
                
            }
             function asignarCantAlarmas() {
                var cantAlarmas = $("#alarma").html();
                var cantPREAlarmas = $("#PREalarma").html();
                document.cookie = 'Alarma (' + cantAlarmas + ' / ' + cantPREAlarmas + ')';
//                $("#itemAlarma").html('Alarma (' + cantAlarmas + ' / ' + cantPREAlarmas + ')');
                
            }
    
      </script>
      
        <?php
        
//        
//        $identity = new UserIdentity('TRAPITO', '123456');
//        $identity->authenticate();
//        Yii::app()->user->login($identity);        
//        echo Yii::app()->user->name;
//        
//        echo'<pre>';
//        echo '0: '; var_dump(Yii::app()->user->getId());
//        
//        echo'3: ';var_dump(Yii::app()->authManager->checkAccess('createDispositivo', '89'));
//        echo'4: ';var_dump(Yii::app()->authManager->checkAccess('admin', '89'));
//        
        
//        die();
        $this->widget(
                'booster.widgets.TbNavbar', array(
            'type' => 'inverse',
            'brand' => 'Inicio',
            'brandUrl' => Yii::app()->homeUrl . 'index.php',
            'collapse' => true, // requires bootstrap-responsive.css
            'fixed' => false,
            'fluid' => true,
            'items' => array(
                array(
                    'class' => 'booster.widgets.TbMenu',
                    'submenuHtmlOptions' => array('class' => 'multi-level'), 
                    'type' => 'navbar',
//                'htmlOptions' => array('class' => 'pull-right'), //MENU A LA IZQUIERDA
                    'items' => array(
//                    array('label' => 'Home', 'url' => '#', 'active' => true),
//                    array('label' => 'Link', 'url' => '#'),

                        array(
                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Dispositivo',
                            'icon'=>'hdd',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Nuevo dispositivo', 'url' => Yii::app()->homeUrl . 'Dispositivo/create'),
                                array('label' => 'Calibrar', 'url' => Yii::app()->homeUrl . 'calibracion/create?id_disp'),
                                array('label' => 'Habilitar Dispositivo', 'url' => Yii::app()->homeUrl . 'Dispositivo/habilitardispositivo'),
                                array(
//                                    'visible' => Yii::app()->user->checkAccess('admin'),
                                    'label' => 'Modificar',
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Listar dispositivos', 'url' => Yii::app()->homeUrl . 'Dispositivo/list'),
                                        array('label' => 'Modificar valores', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),
                                    )
                                ),
                                
                              
                               
                                array(
//                                    'visible' => Yii::app()->user->checkAccess('admin'),
                                    'label' => 'Asignar Dispositivo',
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Generar Asignacion', 'url' => Yii::app()->homeUrl . 'Histoasignacion/create'),
                                        array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Histoasignacion/update'),
                                        array('label' => 'Historial', 'url' => Yii::app()->homeUrl . 'Histoasignacion/list'),
                                    )
                                ),
                            )
                        ),
                        array(
                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Empresa',
                            'icon'=>'briefcase',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Nueva Empresa', 'url' => Yii::app()->homeUrl . 'empresa/create'),
                                array('label' => 'Nueva Sucursal', 'url' => Yii::app()->homeUrl . 'sucursal/create'),
                               
                                array(
                                    'visible' => !Yii::app()->user->isGuest,
                                    'label' => 'Sucursales',
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Listar Sucursales', 'url' => Yii::app()->homeUrl . 'sucursal/index'),
                                        array('label' => 'Modificar valores', 'url' => Yii::app()->homeUrl . 'sucursal/admin'),
                                        
                                    )
                                ),
                                
                                 array(
                                    'visible' => !Yii::app()->user->isGuest,
                                    'label' => 'Empresas',
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Listar Empresas', 'url' => Yii::app()->homeUrl . 'empresa/list'),
                                        array('label' => 'Modificar valores', 'url' => Yii::app()->homeUrl . 'empresa/admin'),                                    
                                        
                                    )
                                ),
                                
                                
                                
                            )
                        ),
                        array(
                            'label' => 'Mapa',
                            'icon'=>'globe',
                            'url' => Yii::app()->homeUrl . 'Histoasignacion/viewmap',
                            'visible' => !Yii::app()->user->isGuest
                        ),
                        array(
                            'id'=>'alarma',
                            'label' => 'Alarma (' . count($PREalarmas) . ' / ' . count($alarmas) . ')',
                            'icon'=>'bell',
                            'url' => array('/alarma/admin'),
                            'visible' => !Yii::app()->user->isGuest,
                            'itemOptions'=>array('id' => 'itemAlarma')
                            ),
                        array(
                            'label' => 'Alarmas asigandas (' . count($asiganciones) . ')',
                            'icon'=>'download-alt',
                            'url' => Yii::app()->homeUrl . 'asignarinspector/index',
                            'visible' => !Yii::app()->user->isGuest
                        ),
                        
                        array(
                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Configuracion',
                            'icon'=>'cog',
                            'url' => '#',
                            'items' => array(
                                array(
                                    'visible' => !Yii::app()->user->isGuest,
                                    'label' => 'Alarma',
                                    
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Parametros', 'url' => Yii::app()->homeUrl . 'configalarma/create'),
                                    )
                                ),
                                array(
                                    'label' => 'Usuario',
                                    'visible' => !Yii::app()->user->isGuest,
                                    'url' => '#',
                                    'items' => array(
                                        array('label' => 'Nuevo Usuario', 'url' => Yii::app()->homeUrl . 'usuario/create'),                                
                                        array('label' => 'Generar Permisos', 'url' => Yii::app()->homeUrl . "usuario/index/rol/0"),
                                        array('label' => 'Listar Usuario', 'url' => Yii::app()->homeUrl . 'usuario/index'),
                                        array('label' => 'Modificar valores', 'url' => Yii::app()->homeUrl . 'usuario/admin'),
                                    )
                                ),
                                array('label' => 'Niveles de Menu', 'url' => Yii::app()->homeUrl . 'nivelesmenu/admin'),                                
                            )
                        ),
                        array(
                            'label' => 'Ayuda',
                            'visible' => !Yii::app()->user->isGuest,
                            'url' => '#',
                            'icon'=>'flag',
                            'items' => array(
                                array('label' => 'Acerca de', 'url' => array('site/about#openModal')),
                                array('label' => 'Contáctenos', 'url' => Yii::app()->homeUrl . "site/contact"),  
                                array('label' => 'Manual del Usuario', 'url' => Yii::app()->homeUrl . "manualusuario.pdf"),
                            )
                        ),
                        
                       
                        array(
                            'label' => 'Cerrar sesión (' . Yii::app()->user->name . ')',
                             'icon'=>'user',
                            'url' => array('/site/logout'),
                            'visible' => !Yii::app()->user->isGuest),
                            'itemOptions'=>array('class'=>'pull-right'),
                        
                        
                    ),
                ),
            ),
                )
        );
        ?>
        
        
        <!-- View Popup   -->
            <?php $this->beginWidget('booster.widgets.TbModal', array('id'=>'viewModal')); ?>
                <!-- Popup Header -->
                <div class="modal-header">
                <div class="modal-header" style="padding:10px 10px;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4><span class="glyphicon glyphicon-pencil"></span> Modificar</h4>
                </div>
                </div>
                <!-- Popup Content -->
                <div class="modal-body">
                <p>  <?php  ?></p>
                </div>
                <!-- Popup Footer -->
                <div class="modal-footer">
                <!-- close button -->
                <!-- close button ends-->
                </div>
            <?php $this->endWidget(); ?>
            <!-- View Popup ends -->          

        <div class="container" id="page">



            





                <?php echo $content; ?>

                </body>
                </html>
