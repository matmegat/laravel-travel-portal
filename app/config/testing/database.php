<?php

return [

    'default' => 'mysql',

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'visits',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

    ],

    'redis' => [

        'cluster' => true,

        'default' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],

    ],

];
