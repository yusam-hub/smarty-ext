<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use YusamHub\SmartyExt\SmartyExt;

$config = require __DIR__ . '/../config/smarty-ext.php';

$smartyExt = new SmartyExt($config['templates']['front']);

$smartyExt->getSmartyEngine()->setLinkedValue('linkedKey1','linkedValue1');

$content = $smartyExt->view('/sub/sub/index', [
    'testKey' => 'testVal',
]);
file_put_contents(__DIR__ . '/../tmp/index.html', $content);

$content2 = $smartyExt->view('/sub/sub/index', [
    'testKey' => 'testVal',
]);
file_put_contents(__DIR__ . '/../tmp/index2.html', $content2);

