<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use YusamHub\SmartyExt\SmartyExt;

$config = require __DIR__ . '/../config/smarty-ext.php';
$smartyExt = new SmartyExt($config['templates']['front']);
$content = $smartyExt->view('/sub/sub/index', [
    'testKey' => 'testVal',
    'publicDir' => realpath(__DIR__ . '/../public'),
    'cssFiles' => [
        realpath(__DIR__ . '/../public/static/test.css')
    ],
    'jsFiles' => [
        realpath(__DIR__ . '/../public/static/test.js')
    ],
]);
file_put_contents(__DIR__ . '/../tmp/index.html', $content);
$content2 = $smartyExt->view('/sub/sub/index', [
    'testKey' => 'testVal',
    'publicDir' => '',
    'cssFiles' => [
        '/static/test.css'
    ],
    'jsFiles' => [
        '/static/test.js'
    ],
]);
file_put_contents(__DIR__ . '/../tmp/index2.html', $content2);

