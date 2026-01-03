<?php

namespace YusamHub\SmartyExt\Extension\Func;

use Smarty\Template;

class SmartyPrintTplVars extends \Smarty\FunctionHandler\Base
{
    public function handle($params, Template $template)
    {
        $out = [];
        foreach($template->tpl_vars as $key => $smarty_Variable) {
            $out[$key] = $smarty_Variable->value;
        }
        return sprintf('<pre>%s</pre>', print_r($out, true));
    }
}