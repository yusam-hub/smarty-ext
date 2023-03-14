<?php
/**
 * @param array $params
 * @param Smarty_Internal_Template $template
 *
 * @return string
 */
function smarty_function_html_include_static($params, $template)
{
    $forceDebugging = (bool) ($params['forceDebugging']??false);
    $publicDir = (string) ($params['publicDir']??'');
    $cssFiles = (array) ($params['cssFiles']??[]);
    $jsFiles = (array) ($params['jsFiles']??[]);
    $dbg = '';
    if ($template->smarty->debugging || $forceDebugging) {
        $dbg = 'dbg='.time();
    }
    $out = [];
    foreach($cssFiles as $cssFile) {
        $cssFile = str_replace($publicDir, '', $cssFile);
        $delimiterQuery = '';
        if (!empty($dbg)) {
            $delimiterQuery = strstr($cssFile, '?') ? '&' : '?';
        }
        $out[] = sprintf('<link rel="stylesheet" href="%s%s%s">', $cssFile, $delimiterQuery, $dbg);
    }
    foreach($jsFiles as $jsFile) {
        $jsFile = str_replace($publicDir, '', $jsFile);
        $delimiterQuery = '';
        if (!empty($dbg)) {
            $delimiterQuery = strstr($jsFile, '?') ? '&' : '?';
        }
        $out[] = sprintf('<script type="text/javascript" src="%s%s%s"></script>', $jsFile, $delimiterQuery, $dbg);
    }
    return sprintf('%s', implode("\n", $out));
}
