<?php

namespace YusamHub\SmartyExt\Extension;

use YusamHub\SmartyExt\Extension\Func\SmartyPrintTplVars;
use YusamHub\SmartyExt\Extension\Func\Ts;

class BaseExtension extends \Smarty\Extension\Base
{
    public function getTagCompiler(string $tag): ?\Smarty\Compile\CompilerInterface {
        return null;
    }

    public function getModifierCompiler(string $modifier): ?\Smarty\Compile\Modifier\ModifierCompilerInterface {
        return null;
    }

    public function getFunctionHandler(string $functionName): ?\Smarty\FunctionHandler\FunctionHandlerInterface {
        if (strpos($functionName, 'ts') !== false) {
            return new Ts();
        } elseif (strpos($functionName, 'smarty_print_tpl_vars') !== false) {
            return new SmartyPrintTplVars();
        }
        return null;
    }

    public function getBlockHandler(string $blockTagName): ?\Smarty\BlockHandler\BlockHandlerInterface {
        return null;
    }

    public function getModifierCallback(string $modifierName) {
        return null;
    }

    public function getPreFilters(): array {
        return [];
    }

    public function getPostFilters(): array {
        return [];
    }

    public function getOutputFilters(): array {
        return [];
    }
}