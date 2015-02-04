<?php

define('WEBEEZ_MODEL_LIB', dirname(__FILE__) . '/../models');
define('WEBEEZ_LIB', dirname(__FILE__) . '/../');
define('YII_PATH',WEBEEZ_LIB.'../framework'.DIRECTORY_SEPARATOR);

// Add model folder to include path.
//set_include_path(get_include_path().PATH_SEPARATOR.WEBEEZ_MODEL_LIB);

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
//	'name'=>'My Web Application',

	// preloading 'log' component
//	'preload'=>array('log'),
    'preload'=>array(),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.controllers.BaseController',
//        'webeez.classes.ChineseTrans',
        'webeez.extensions.DomainListener',
	),
    'defaultController' => 'site',
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('10.0.2.2','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
*/
        'urlManager' => array(
            'class' => 'webeez.classes.WebeezUrlManager',
            'urlFormat' => 'path',
            'caseSensitive' => true,
            'showScriptName' => false,
            'rules' => include('route.php'),
            'secureHost' => 'http://www.hpw-vera.com',
            'commonHost' => 'http://www.hpw-vera.com',
            'cdn' => array(
                // provider => domain
                //'default' => 'xxx.rackcdn.com', // Note: just domain here, no schema
                'qiniu' => array(
                    'http' => 'http://toursforfun.qiniudn.com',
                    'https' => 'https://toursforfun.qiniudn.com',
                ),
            ),
        ),
        'authManager' => array('class' => 'webeez.classes.WebeezAuthManager'),
//        'numberFormatter' => array('class' => 'webeez.classes.WebeezNumberFormatter'),
        'user' => array(
            'class' => 'webeez.classes.WebeezCustomer',
            'returnUrl' => array('MyAccount/index'),
            'loginUrl' => array('Account/login'),
            'allowAutoLogin' => true
        ),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/hpw.db',
//            'class' => 'webeez.extensions.DbConnection', //CDbConnection
//            'emulatePrepare' => true,
//            'charset' => 'utf8',
//            'connectionString' => 'mysql:host=localhost;dbname=transfer',
//            'username' => 'root',
//            'password' => 'root'
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
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
        'language' => 'zh_cn',
	),
);