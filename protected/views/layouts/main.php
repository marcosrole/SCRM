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
                            )
                        ),
                        array(
//                            'visible' => !Yii::app()->user->isGuest,
                            'label' => 'Empresa',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Añadir', 'url' => Yii::app()->homeUrl . 'empresa/crear'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'empresa/modificar'),
                                array('label' => 'Listar', 'url' => Yii::app()->homeUrl . 'empresa/list'),
                                '--------------------------',
                                array('label' => 'Añadir Sucursal', 'url' => Yii::app()->homeUrl . 'sucursal/crear'),
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
                                array('label' => 'Generar', 'url' => Yii::app()->homeUrl . 'Histoasignacion/crear'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Histoasignacion/modificar'),
                                array('label' => 'Historial', 'url' => Yii::app()->homeUrl . 'Histoasignacion/list'),
                            )
                        ),
                        array(
                            'label' => 'Usuario',
//                            'visible' => !Yii::app()->user->isGuest,
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'usuario/crear'),
                                array('label' => 'Permisos', 'url' => Yii::app()->homeUrl . 'usuario/permisos'),
                                '----------',
                                array('label' => 'Listar Usuarios', 'url' => Yii::app()->homeUrl . 'usuario/list'),
//                                array(
//                                    'label' => 'Ver', 
//                                    'url' => '#',
//                                    'items' => array(
//                                        array('label' => 'Listar Usuarios', 'url' => Yii::app()->homeUrl . 'usuario/list'),
//                                        )
//                                    ),                                  
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'usuario/adminusuarios'),
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
                    ),
                ),
            ),
                )
        );
        ?>

        <div class="container" id="page">



            





                <?php echo $content; ?>

                </body>
                </html>
