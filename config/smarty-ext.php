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
                'pluginDir' => __DIR__ .'/../resources/smarty_plugins',
                'templateDir' => __DIR__ .'/../resources/views/front',
                'configDir' => __DIR__ .'/../resources/views/front',
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
