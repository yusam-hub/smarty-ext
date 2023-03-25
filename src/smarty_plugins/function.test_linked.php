<?php

/**
 * @param array $params
 * @param Smarty_Internal_Template $template
 * @return string
 */
function smarty_function_test_linked(array $params, $template): string
{
    if ($template->smarty instanceof \YusamHub\SmartyExt\SmartyEngine) {
        return $template->smarty->getLinkedValue('linkedKey1');
    }
    return '';
}
