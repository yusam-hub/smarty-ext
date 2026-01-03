<?php

namespace YusamHub\SmartyExt\Extension\Func;

use Smarty\Template;

class Ts extends \Smarty\FunctionHandler\Base
{
    public function handle($params, Template $template)
    {
        return time();
    }
}