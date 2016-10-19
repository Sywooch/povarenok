<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
	'name' => 'povarenok.by',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'ru-RU',
	'sourceLanguage' => 'ru-RU',
	'controllerMap' => [
        'images' => [
            'class' => 'phpnt\cropper\controllers\ImagesController',
        ],
    ],		
    'modules' => [
        'adminpanel' => [
            'class' => 'app\modules\adminpanel\Module',
        ],
        'comments' => [
            'class' => 'app\modules\comments\Module',
        ],
        'users' => [
            'class' => 'app\modules\users\Module',
        ],
        'article' => [
            'class' => 'app\modules\article\Module',
        ],	
        'recepty' => [
            'class' => 'app\modules\recepty\Module',
        ],		
        'admin' => [
            'class' => 'mdm\admin\Module',
			'layout' => 'right-menu',
			'mainLayout' => '@app/modules/adminpanel/views/layouts/main.php',
        ],		
    ],	
    'components' => [	
        'request' => [
            'cookieValidationKey' => 'j3qq4h7h2v',
        ],		
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
		'urlManager' => [
            'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [ 
				'adminpanel' => 'adminpanel/site/index', 
				'recepty' => 'recepty/default/index',					
				'ingredients' => 'recepty/ingredients/index',
				'ingredients/parse' => 'recepty/ingredients/parse',
				'ingredients/<path:.+>' => 'recepty/default/ingredient',
				'recepty/add_recept' => 'recepty/default/add_recept',						
				'recepty/notifications' => 'recepty/default/notifications',					
				'recepty/parse' => 'recepty/default/parse',					
				'recepty/search' => 'recepty/default/search',					
				'recepty/<path:.+>' => 'recepty/default/filtr',				
				'recept/<path:.+>' => 'recepty/default/view',		
				'user/id<id:.+>' => 'users/site/view',	
				'users' => 'users/site/index',				
				'users/dialog<id:.+>' => 'users/messages/dialog',								
				'users/friends' => 'users/friends/index',								
				'users/messages' => 'users/messages/index',								
				'users/users-like' => 'users/users-like/index',								
				'users/settings' => 'users/settings/index',
				'article' => 'article/default/index',	
				'articles/<path:.+>' => 'article/default/filtr',
				'article/<path:.+>' => 'article/default/view',
				'sitemap.xml' => 'sitemap/index',
				'<controller:\w+>/page/<page:\d+>' => '<controller>/index',
				'<controller:\w+>' => '<controller>/index',				
			]
        ],			
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],			
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
