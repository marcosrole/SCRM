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
                            'label' => 'Dispositivo',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'Dispositivo/create'),
                                array('label' => 'Ver', 'url' => Yii::app()->homeUrl . 'Dispositivo/list'),
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),                                
                                array('label' => 'Asignar', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),
                             
                            )
                        ),
                        array(
                        'label' => 'Empresa',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Añadir', 'url' => Yii::app()->homeUrl . 'empresa/crear'),
                                array('label' => 'Modificar', 'url' => '#'),
                                array('label' => 'Listar', 'url' => Yii::app()->homeUrl . 'empresa/list'),
                             
                            )
                        ),
                        array('label'=>'Mapa', 'url'=> Yii::app()->homeUrl . 'Histoasignacion/viewmap', 'visible'=>Yii::app()->user->isGuest),
                         array(
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
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'usuario/crear'),
                                array('label' => 'Ver', 'url' => Yii::app()->homeUrl . '#',
                                    'items' => array(
                                        array('label' => 'Listar Usuarios', 'url' => Yii::app()->homeUrl . '#'),
                                        ),
                                    ),                                  
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . '#'),
                            )
                        ),
                        
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
