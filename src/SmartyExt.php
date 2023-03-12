<?php

namespace YusamHub\SmartyExt;

class SmartyExt
{
    public string $vendorDir;
    public string $extension;
    private array $config;
    private \Smarty $smarty;
    public function __construct(array $config)
    {
        $this->config = $config;
        $configSmartyExt = $this->config['smartyExt']??[];
        foreach($configSmartyExt as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            }
        }

        require_once(rtrim($this->vendorDir, '/') . '/smarty/smarty/libs/bootstrap.php');

        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir($this->config['smartyDirs']['templateDir']??'');
        $this->smarty->setConfigDir($this->config['smartyDirs']['configDir']??'');
        $this->smarty->setCompileDir($this->config['smartyDirs']['compileDir']??'');
        $this->smarty->setCacheDir($this->config['smartyDirs']['cacheDir']??'');
        $this->smarty->registerPlugin('modifier','md5', function($string){
            return md5($string);
        });
        $configSmarty = $this->config['smarty']??[];
        foreach($configSmarty as $k => $v) {
            if (property_exists($this->smarty, $k)) {
                $this->smarty->{$k} = $v;
            }
        }
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws \SmartyException
     */
    public function view(string $template, array $params = []): string
    {
        $this->smarty->assign($params);

        if (file_exists($template) && !is_dir($template)) {
            return strval($this->smarty->fetch($template));
        }

        $templateDir = $this->smarty->getTemplateDir();
        if (isset($templateDir[0])) {
            $templateDir = $templateDir[0];
        }

        if (!is_string($templateDir)) {
            throw new \RuntimeException("Smarty getTemplateDir return not string");
        }

        if (substr($template, -1 * strlen($this->extension)) != $this->extension) {
            $template .= $this->extension;
        }

        $fullTemplate = rtrim($templateDir, '/') . '/' .  ltrim($template, '/');
        if (file_exists($fullTemplate)) {
            return strval($this->smarty->fetch($template));
        }
        throw new \RuntimeException(sprintf("Template [%s] not exists", $fullTemplate));
    }
}