<?php
return [
	'class' => 'nodge\eauth\EAuth',
	'popup' => true, // Use the popup window instead of redirecting.
	'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
	'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
	'httpClient' => [
		// uncomment this to use streams in safe_mode
		//'useStreamsFallback' => true,
	],
	'services' => [ // You can change the providers and their classes.
		'vkontakte' => [
			// register your app here: https://vk.com/editapp?act=create&site=1
			'class' => 'nodge\eauth\services\VKontakteOAuth2Service',
			'clientId' => '5099014',
			'clientSecret' => 'B6fv0AclLmMmLya1Zm1I',
		],
		'facebook' => [
			// register your app here: https://developers.facebook.com/apps/
			'class' => 'nodge\eauth\services\FacebookOAuth2Service',
			'clientId' => '804523776355866',
			'clientSecret' => '8c55abe182b73c2d222ef89604d895bc',
		],		
	],	
];
