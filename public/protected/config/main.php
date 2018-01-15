<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$modules = require(dirname(__FILE__).'/modules.php');


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
        'config'=>array( 'class' => 'SConfig'),
        /*'debug' => array(
            'class' => 'application.extensions.debug.Yii2Debug', // manual installation
        ),*/
        'MultiMailer' => array(
            'class' =>'application.extensions.MultiMailer.MultiMailer',
            'setFromAddress' => 'nasport51217@gmail.com',
            'setFromName' => 'NaSportUa',
            'setMethod' => 'GMAIL',
            'setOptions'     => array(
                'Username' => 'nasport51217@gmail.com',
                'Password' => 'nasport123',
            ),
        ),
        'loid' => array(
            //'class' => 'ext.lightopenid.loid',
            'class' => 'application.modules.login.widgets.lightopenid.loid',
        ),
        /*'eauth' => array(
           // 'class' => 'ext.eauth.EAuth',
            'class' => 'application.modules.login.widgets.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.

            'services' => array( // You can change the providers and their classes.
                'facebook' => array(
                    'class' => 'CustomFacebookService',
                    'client_id' => '1261998653879903',
                    'client_secret' => '4f4fe0216921910a82827923771dc95a',
                ),
//                'google_oauth' => array(
//                    // register your app here: https://code.google.com/apis/console/
//                    'class' => 'GoogleOAuthService',
//                    'client_id' => '732994437426-17cld5d7phqsvoq18al8d42hhl7ejen0.apps.googleusercontent.com',
//                    'client_secret' => 'xerwBOR0CfZIyjOIRyTLSqUT',
//                    'title' => 'Google Plus',
//                ),
//                'vkontakte' => array(
//                    'class' => 'VKontakteOAuthService',
//                    'client_id' => '',
//                    'client_secret' => '',
//                ),
//                'mailru' => array(
//                    'class' => 'MailruOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                ),
//                'yandex' => array(
//                    'class' => 'YandexOpenIDService',
//                ),
//                'twitter' => array(
//                    'class' => 'TwitterOAuthService',
//                    'key' => '...',
//                    'secret' => '...',
//                ),
            ),
        ),*/
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
                'admin/default/settings'=>'admin/default/settings',
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


//				'owner'=>'owner/default/index',
//				'owner/login'=>'owner/default/login',
//
//				'owner/<module:\w+>'=>'<module>/owner/default',
//				'owner/<module:\w+>/<controller:\w+>'=>'<module>/owner/<controller>',
//				'owner/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/owner/<controller>/<action>',
//				'owner/<module:\w+>/<controller:\w+>/<action:\d+>'=>'<module>/owner/<controller>/<action>',
//				'owner/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/owner/<controller>/<action>',


//                'manager'=>'manager/default/index',
//                'manager/login'=>'manager/default/login',
////                'manager/task/in-work'=>'task/manager/inWork',
//
//                'manager/<module:\w+>'=>'<module>/manager/default',
//                'manager/<module:\w+>/<controller:\w+>'=>'<module>/manager/<controller>',
//                'manager/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/manager/<controller>/<action>',
//                'manager/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/manager/<controller>/<action>',



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
        //'cache'=>array('class'=>'system.caching.CFileCache'),// CFileCache включить кеширование
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
