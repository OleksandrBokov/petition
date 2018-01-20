<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$modules = require(dirname(__FILE__).'/modules.php');

//echo "<pre>";
//var_dump(Yii::app()->config->get('capchaKey'));
//echo "</pre>";die;
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'petition',
    'sourceLanguage'=>'en_US',
    'theme'=>'classic',
    'language'=>'uk',
	// preloading 'log' component
	'preload'=>array('log','config', 'parseModuleHelper', 'debug'),

	// autoloading model and component classes
	'import'=>array(
	    //'application.extensions.JsTrans.*',
		'application.models.*',
		'application.components.*',
        //'application.modules.city.models.*',
        //'application.modules.task.models.*',
        //'application.modules.task.modules.admin.models.*',
	),

	'modules'=> array_replace($modules, array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),

    )),
	// application components
	'components'=>array(
		'reCaptcha' => array(
			'name' => 'reCaptcha',
			'class' => 'ext.yiiReCaptcha.ReCaptcha',
//			'key' => Yii::app()->config->get('capchaKey'),
			'key' => '6LerWkEUAAAAALoLORUIu3YT8uxy80vBXc4c0qWU',
//			'key' => '6LerW',
			//'secret' => Yii::app()->config->get('capchaSecretKey'),
			'secret' => '6LerWkEUAAAAAOoN8XEojG23mWgcm7Gjwv7Twd0S',
//			'secret' => '6LerW',
		),
        'config'=>array( 'class' => 'SConfig'),
        /*'debug' => array(
            'class' => 'application.extensions.debug.Yii2Debug', // manual installation
        ),*/
        'MultiMailer' => array(
            'class' =>'application.extensions.MultiMailer.MultiMailer',
            'setFromAddress' => 'dahanavar12@gmail.com',
            'setFromName' => 'Petition',
            'setMethod' => 'GMAIL',
            'setOptions'     => array(
                'Username' => 'dahanavar12@gmail.com',
                'Password' => '04150464',
            ),
        ),
        'loid' => array(
            //'class' => 'ext.lightopenid.loid',
            'class' => 'application.modules.login.widgets.lightopenid.loid',
        ),

//        'request'=>array(
//            'class'=>'SLanguageHttpRequest',
//        ),
        'user'=>array(
            'allowAutoLogin'=>true,
            'class' => 'WebUser',
        ),
        'authManager' => array(
            // Будем использовать свой менеджер авторизации
            'class' => 'PhpAuthManager',
            // Роль по умолчанию. Все, кто не админы, работодатели и работники — гости.
            'defaultRoles' => array('guest'),
        ),
        'Cookies' => array('class' => 'application.components.CookiesHelper'),
		// uncomment the following to enable URLs in path-format
        'urlManager'=> array(
            'class'=>'SLanguageUrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'useStrictParsing'=>true,

            'rules'=>array(
                '/' => 'site/index',

                'logout'=>'/login/default/logout',
                'login/reset/password'=>'/login/reset/password',
                'login/reset/successful'=>'/login/reset/successful',

                'login/ajax'=>'login/default/ajax',
                'moderator/registration'=>'/login/default/registration',
                'user/registration'=>'/user/default/registration',
				'moderator/afterregistration' => '/login/default/afterregistration',
//				'petition/moderator/create'=>'/petition/default/create',
//				login/moderator/registration
//                'task/comment'=>'task/comment/index',
//
//                'site/playground'=>'/task/playground',
//                'playground/<id:\d+>'=>'playground/index/view',
//                'place/<id:\d+>'=>'place/index/view',
//                'section/<id:\d+>'=>'section/index/view',
//
//                'playground/auth/<id:\d+>'=>'playground/order/auth/',
//                'playground/booking/<id:\d+>'=>'playground/order/booking/',

//                'section/auth/<id:\d+>/<date:\d+>'=>'section/order/auth/<id>/<date>',
//                'section/booking/<id:\d+>/<date:\d+>'=>'section/order/booking/',

//                'ajax/checkNewBid'=>'task/ajax/checkNewBid',
//                'ajax/checkNewTask'=>'task/ajax/checkNewTask',


                'admin'=>'admin/default/index',
//                'admin/default/capcha'=>'admin/default/capcha',
                'admin/default/link'=>'admin/default/link',
                'admin/login'=>'admin/default/login',

                'admin/<module:\w+>'=>'<module>/admin/default',
                'admin/<module:\w+>/<controller:\w+>'=>'<module>/admin/<controller>',
                'admin/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/admin/<controller>/<action>',


				'user'=>'user/default/index',
				'user/login'=>'user/default/login',

				'user/<module:\w+>'=>'<module>/user/default',
				'user/<module:\w+>/<controller:\w+>'=>'<module>/user/<controller>',
				'user/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/user/<controller>/<action>',
				'user/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/user/<controller>/<action>',


				'moderator'=>'moderator/default/index',
				'moderator/login'=>'moderator/default/login',

				'moderator/<module:\w+>'=>'<module>/moderator/default',
				'moderator/<module:\w+>/<controller:\w+>'=>'<module>/moderator/<controller>',
				'moderator/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/moderator/<controller>/<action>',
				'moderator/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/moderator/<controller>/<action>',
				

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',



                '<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/<controller>/<action>', ///???



                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
            ),
        ),
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),
        'cache'=>array('class'=>'system.caching.CFileCache'),// CFileCache включить кеширование
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),
        'session' => array(
//            'class'=>'system.web.CDbHttpSession',
//            'connectionID' => 'db',
//            'sessionTableName'=>'session',
//            'autoCreateSessionTable' => true,

            'cookieMode' => 'allow',
//            'cookieParams' => array(
//                'path' => '/',
//                'domain' => '.sportportal.loc',
//                'httpsOnly' => true,
//            ),
        ),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',//, warning
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
	'params'=>require(dirname(__FILE__).'/params.php'),
);
