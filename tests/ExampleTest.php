<?php

namespace YusamHub\SmartyExt\Tests;

use YusamHub\SmartyExt\SmartyExt;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws \SmartyException
     */
    public function testDefault()
    {
        $config = require __DIR__ . '/../config/smarty-ext.php';
        $smartyExt = new SmartyExt($config['templates']['front']);
        $content = $smartyExt->view('index', [
            'testKey' => 'testVal'
        ]);
        file_put_contents(__DIR__ . '/../tmp/test.html', $content);
        $this->assertTrue(true);

        $smartyExt2 = new SmartyExt($config['templates']['front']);
        $content = $smartyExt2->view(__DIR__ . '/../resources/views/back/index.tpl', [
            'testKey' => 'testVal'
        ]);
        file_put_contents(__DIR__ . '/../tmp/test2.html', $content);
        $this->assertTrue(true);
    }
}