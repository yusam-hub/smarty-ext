<?php

return [
    'default' => 'front',

    'templates' => [
        'front' => [
            'smarty' => [
                'debugging' => true,
                'force_compile' => true,
                'caching' => false,
                'cache_lifetime' => 120,
            ],
            'smartyDirs' => [
                'templateDir' => __DIR__ .'/../resources/views/front',
                'configDir' => __DIR__ .'/../resources/views/front/configs',
                'compileDir' => __DIR__ .'/../tmp/compiles/front',
                'cacheDir' => __DIR__ .'/../tmp/caches/front',
            ],
            'smartyExt' => [
                'extension' => '.tpl',
                'vendorDir' => __DIR__ . '/../vendor',
            ],
        ],
    ],
];
