<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'NaijaHouses.com',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
//                'domain' => ".vcap.me",
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
            'enableSession' => true,
            'authTimeout' => 30,
            'identityCookie' => ['name' => '_identity-frontend', 'path' => '/',
//            'domain' => ".vcap.me", 
            'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                'path' => '/',
//                'lifetime' => 3000
//                'domain' => ".vcap.me",
            ],
//            'timeout' => 3000,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'http://<slug:\w+(?!www).>.vcap.me/' => 'user/view-profile',
                'property-details/<slug:[a-zA-Z0-9_ -]+>' => 'property/view',
                'rental-details/<slug:[a-zA-Z0-9_ -]+>' => 'rental/view',
                'hotel-details/<slug:[a-zA-Z0-9_ -]+>' => 'hotel/view',
                'agency-details/<slug:[a-zA-Z0-9_ -]+>' => 'agency/view',
            ],
        ],
//        'cm' => [ // bad abbreviation of "CashMoney"; not sustainable long-term
//            'class' => 'frontend/components/CashMoney', // note: this has to correspond with the newly created folder, else you'd get a ReflectionError
//            // Next up, we set the public parameters of the class
//            'client_id' => 'AdsxvEnSFAYhy4Y7JqOxpM9mJ9xtG25fwm8mc8FWcOSqGp5fWJPXEVCDq9j0_-csRORqNHeRnH6-JhIC',
//            'client_secret' => 'ELRTUjPMKkr4ApzLma-2Xsgnh5yVHkVfNu7ZhwtYEoTlyIGgeYleIJiq3NYhq73umZhs4lYlc16JCYyq',
//        // You may choose to include other configuration options from PayPal
//        // as they have specified in the documentation
//        ],
        
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
            // uncomment this to use streams in safe_mode
            //'useStreamsFallback' => true,
            ],
            'services' => [ // You can change the providers and their classes.
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '295891977497341',
                    'clientSecret' => 'fe6dbdf10b210e296970ff863bc1ac97',
                    'title' => 'Facebook',
                ],
                'google' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '957639477141-q2gfi8vpc32bktd1p3er60c8pejvijum.apps.googleusercontent.com',
                    'clientSecret' => 'K2QGDs9NjRRULp0jbbqfVkDQ',
                    'title' => 'Google',
                ],
            ],
        ],
        
        'i18n' => [
            'translations' => [
                'eauth' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => [
                        'eauth' => 'eauth.php'
                    ]
                ]
            ]
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',
            // the global settings for the facebook widget
            'facebook' => [
                'appId' => '295891977497341',
            ],
            'twitter' => [
                'screenName' => 'TWITTER_SCREEN_NAME',
            ],
            'google' => [
                'clientId' => '957639477141-q2gfi8vpc32bktd1p3er60c8pejvijum.apps.googleusercontent.com',
                'pageId' => '',
                'profileId' => 'K2QGDs9NjRRULp0jbbqfVkDQ',
            ],
        ],
    ],
    'params' => $params,
];
