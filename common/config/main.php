<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'dateFormat' => 'php:d/m/Y',
            'datetimeFormat' => 'php:d/m/Y g:i A',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'NGN',
            'sizeFormatBase' => 1048576
//            'defaultTimeZone' => 'Asia/Kolkata'
       ],
    ],
];
