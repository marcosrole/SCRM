<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Sistema de Control de Ruidos Molestos',

	// preloading 'log' component
	'preload'=>array('log','booster'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'ext.yii-mail.YiiMailMessage',
                
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
                
                'mail' => array(
                    'class' => 'ext.yii-mail.YiiMail',
                    'transportType' => 'smtp',
                    'transportOptions' => array(
                        'host' => 'smtp.gmail.com',
                        'encryption' => 'ssl',
                        'username' => 'marcosrole@gmail.com',
                        'password' => 'vera2016',
                        'port' => 465,
                    ),
                    'viewPath' => 'application.views.mails',
                ),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('site/login'),
		),
                'booster' => array(
                      'class' => 'ext.booster.components.Booster',
                ),

		// uncomment the following to enable URLs in path-format
	
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'caseSensitive'=>false,
                       
			'rules'=>array(                            
                            'dispositivo/create/<id_dispositivo>/<ubic>'=>'dispositivo/create',                            
                            'detalledispo/create/<id>/<db>/<dist>/<fecha>/<hs>'=>'detalledispo/create',                            
//                            'dispositivo/<id:\d+>/<txt>'=>'dispositivo/create',                            
                            'dispositivo/<id:\d+>'=>'dispositivo/create',
                            
                            
//                            
//                            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//                            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),
                
                'authManager'=>array(
                    'class'=>'CDbAuthManager',
                    'connectionID'=>'db',
                   ), 
            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
