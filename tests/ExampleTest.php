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
        file_put_contents(__DIR__ . '/../tmp/front.html', $content);
        $this->assertTrue(true);
    }
}