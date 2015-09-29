<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
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
        $this->widget(
                'booster.widgets.TbTabs',
                array(
                    'type' => 'tabs', // 'tabs' or 'pills'
                    'tabs' => array(
                        array(
                            'label' => 'Home',
                            'content' => $this->render('list'),
                            'active' => true
                        ),
                        array('label' => 'Profile', 'content' => 'Profile Content'),
                        array('label' => 'Messages', 'content' => 'Messages Content'),
                    ),
                )
            );
        ?>
    </body>
</html>
