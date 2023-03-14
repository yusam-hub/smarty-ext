FRONT {$testKey|md5} {ts} {test}
{smarty_print_tpl_vars}
{html_include_static cssFiles=$cssFiles jsFiles=$jsFiles publicDir="{$publicDir}" forceDebugging=true}
{if ($_smarty_debugging)}{debug}{/if}
