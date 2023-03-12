<?php

namespace YusamHub\SmartyExt;

class SmartyExt
{
    public string $vendorDir;
    public string $extension;
    private array $config;

    private \Smarty $smarty;

    /**
     * @param array $config
     * @throws \SmartyException
     */
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
     * @return string
     */
    public function getTemplateDir(): string
    {
        $templateDir = $this->smarty->getTemplateDir();
        if (is_array($templateDir) && isset($templateDir[0])) {
            return rtrim($templateDir[0], '/');
        } elseif (is_string($templateDir)) {
            return rtrim($templateDir,'/');
        }
        throw new \RuntimeException("Unable to detect templateDir");
    }

    /**
     * @param string $template
     * @return string
     */
    private function fetch(string $template): string
    {
        try {
            return (string)$this->smarty->fetch($template) . ($this->smarty->debugging ? '{debug}' : '');
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage(),$e->getCode(), $e);
        }
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    public function view(string $template, array $params = []): string
    {
        $this->smarty->assign($params);

        if (file_exists($template) && !is_dir($template)) {
            return strval($this->fetch($template));
        }

        if (substr($template, -1 * strlen($this->extension)) != $this->extension) {
            $template .= $this->extension;
        }

        $fullTemplate = $this->getTemplateDir() . '/' .  ltrim($template, '/');

        if (file_exists($fullTemplate)) {
            return $this->fetch($template);
        }

        throw new \RuntimeException(sprintf("Template [%s] not exists", $fullTemplate));
    }
}