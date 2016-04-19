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

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <?php
//        $self="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; //obtengo la URL donde estoy
//        header("refresh:10; url=$self"); //Refrescamos cada 10 segundos

        $usuario = new Usuario();
        $usuario=Usuario::model()->find();
        
        $this->widget(
                'booster.widgets.TbNavbar', array(
            'type' => 'inverse',
            'brand' => 'Home',
            'brandUrl' => Yii::app()->homeUrl . 'index.php',
            'collapse' => true, // requires bootstrap-responsive.css
            'fixed' => false,
            'fluid' => true,
            'items' => array(
                array(
                    'class' => 'booster.widgets.TbMenu',
                    'type' => 'navbar',
//                'htmlOptions' => array('class' => 'pull-right'), //MENU A LA IZQUIERDA
                    'items' => array(
//                    array('label' => 'Home', 'url' => '#', 'active' => true),
//                    array('label' => 'Link', 'url' => '#'),

                        array(
//                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Dispositivo',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'Dispositivo/create'),
                                array('label' => 'Ver', 'url' => Yii::app()->homeUrl . 'Dispositivo/list'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),
                                array('label' => 'Calibrar', 'url' => Yii::app()->homeUrl . 'calibracion/create?id_disp'),
                            )
                        ),
                        array(
//                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Empresa',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Añadir', 'url' => Yii::app()->homeUrl . 'empresa/create'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'empresa/admin'),
                                array('label' => 'Listar', 'url' => Yii::app()->homeUrl . 'empresa/list'),
                                '--------------------------',
                                array('label' => 'Añadir Sucursal', 'url' => Yii::app()->homeUrl . 'sucursal/create'),
                                array('label' => 'Listar Sucursales', 'url' => Yii::app()->homeUrl . 'sucursal/index'),
                            )
                        ),
                        array(
                            'label' => 'Mapa',
                            'url' => Yii::app()->homeUrl . 'Histoasignacion/viewmap',
//                            'visible' => !Yii::app()->user->isGuest
                        ),
                        array(
//                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Asignar',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Generar', 'url' => Yii::app()->homeUrl . 'Histoasignacion/create'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Histoasignacion/update'),
                                array('label' => 'Historial', 'url' => Yii::app()->homeUrl . 'Histoasignacion/list'),
                            )
                        ),
                        array(
                            'label' => 'Usuario',
//                            'visible' => !Yii::app()->user->isGuest,
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'usuario/create'),                                
                                array('label' => 'Permisos', 'url' => Yii::app()->homeUrl . "usuario/index/rol/0"),
                                '----------',
                                array('label' => 'Listar Usuarios', 'url' => Yii::app()->homeUrl . 'usuario/index'),
//                                array(
//                                    'label' => 'Ver', 
//                                    'url' => '#',
//                                    'items' => array(
//                                        array('label' => 'Listar Usuarios', 'url' => Yii::app()->homeUrl . 'usuario/list'),
//                                        )
//                                    ),                                  
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'usuario/admin'),
                            )
                        ),
                        
                      
                        array(
                            'label' => 'Login',
                            'url' => Yii::app()->homeUrl,
                            'visible' => Yii::app()->user->isGuest),
                            'htmlOptions' => array('class' => 'pull-right'),
                        array(
                            'label' => 'Logout (' . Yii::app()->user->name . ')',
                            'url' => array('/site/logout'),
                            'visible' => !Yii::app()->user->isGuest),
                        array(
                            'label' => 'Alarma (' . Alarma::model()->count() . ')',
                            'url' => array('/alarma/admin'),
                            //'visible' => !Yii::app()->user->isGuest),
                            ),
                        array(
                            'label' => 'Ayuda',
//                            'visible' => !Yii::app()->user->isGuest,
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Acerca de', 'url' => array('site/about#openModal')),
                                array('label' => 'Contáctenos', 'url' => Yii::app()->homeUrl . "site/contact"),                                
                            )
                        ),
                        
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
