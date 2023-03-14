<?php
/**
 * @param array $params
 * @param Smarty_Internal_Template $template
 *
 * @return string
 */
function smarty_function_smarty_print_tpl_vars($params, $template)
{
    $out = [];
    foreach($template->smarty->tpl_vars as $key => $smarty_Variable) {
        $out[$key] = $smarty_Variable->value;
    }
    return sprintf('<pre>%s</pre>', print_r($out, true));
}
