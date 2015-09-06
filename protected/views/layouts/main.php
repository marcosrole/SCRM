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
                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),
                                array('label' => 'Asignar', 'url' => Yii::app()->homeUrl . 'Dispositivo/admin'),
                                
//                            array('label' => 'Another action', 'url' => '#'),
//                            array(
//                                'label' => 'Something else here',
//                                'url' => '#'
//                            ),
//                            '---',
//                            array('label' => 'NAV HEADER'),
//                            array('label' => 'Separated link', 'url' => '#'),
//                            array(
//                                'label' => 'One more separated link',
//                                'url' => '#'
//                            ),
                            )
                        ),
                        array(
                        'label' => 'Empresa',
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Crear', 'url' => '#'),
                                array('label' => 'Modificar', 'url' => '#'),
                                array('label' => 'Ver', 'url' => '#'),
                                
                                
//                            array('label' => 'Another action', 'url' => '#'),
//                            array(
//                                'label' => 'Something else here',
//                                'url' => '#'
//                            ),
//                            '---',
//                            array('label' => 'NAV HEADER'),
//                            array('label' => 'Separated link', 'url' => '#'),
//                            array(
//                                'label' => 'One more separated link',
//                                'url' => '#'
//                            ),
                            )
                        ),
                        array('label'=>'Mapa', 'url'=> Yii::app()->homeUrl . 'dispositivo/viewmap', 'visible'=>Yii::app()->user->isGuest),
//                        array('label'=>'Login', 'url'=> Yii::app()->homeUrl . 'usuario/loging', 'visible'=>Yii::app()->user->isGuest),
//                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/usuario/logout'), 'visible'=>!Yii::app()->user->isGuest),
//                         array(
//                            'label' => 'Login (Admin)',
//                            'url' => '#',
//                            'items' => array(
//                                array('label' => 'Crear', 'url' => Yii::app()->homeUrl . 'usuario/create'),
//                                array('label' => 'Ver', 'url' => Yii::app()->homeUrl . 'usuario/list'),
//                                array('label' => 'Modificar', 'url' => Yii::app()->homeUrl . 'usuario/admin'),
//                             
//                            )
//                        ),
                        
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
