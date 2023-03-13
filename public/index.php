<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use YusamHub\SmartyExt\SmartyExt;

$config = require __DIR__ . '/../config/smarty-ext.php';
$smartyExt = new SmartyExt($config['templates']['front']);
$content = $smartyExt->view('index', [
    'testKey' => 'testVal'
]);
file_put_contents(__DIR__ . '/../tmp/index.html', $content);
