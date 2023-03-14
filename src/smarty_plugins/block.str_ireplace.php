<?php
/**
 * Smarty plugin to format text blocks
 *
 * @package    Smarty
 * @subpackage PluginsBlock
 */
/**
 * @param array $params   parameters
 * @param string $content  contents of the block
 * @param Smarty_Internal_Template $template template object
 * @param boolean &$repeat  repeat flag
 *
 * @return string content
 */
function smarty_block_str_ireplace($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    return str_ireplace($params['search']??'', $params['replace']??'', $content);
}
