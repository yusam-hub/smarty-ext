<?php

namespace YusamHub\SmartyExt;

class SmartyExt
{
    public string $vendorDir;
    public string $extension;
    private array $config;

    private SmartyEngine $smarty;

    /**
     * @param array $config
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

        $this->smarty = new SmartyEngine();
        $this->smarty->setTemplateDir($this->config['smartyDirs']['templateDir']??'');
        $this->smarty->setConfigDir($this->config['smartyDirs']['configDir']??'');
        $this->smarty->setCompileDir($this->config['smartyDirs']['compileDir']??'');
        $this->smarty->setCacheDir($this->config['smartyDirs']['cacheDir']??'');
        $this->smarty->addPluginsDir($this->config['smartyDirs']['pluginDir']??'');
        $configSmarty = $this->config['smarty']??[];
        foreach($configSmarty as $k => $v) {
            if (property_exists($this->smarty, $k)) {
                $this->smarty->{$k} = $v;
            }
        }
        $this->registerPlugins();
    }

    /**
     * @return void
     */
    private function registerPlugins(): void
    {
        try {
            $this->smarty->registerPlugin('modifier', 'md5', function(string $string) {
                return md5($string);
            });
        } catch (\SmartyException $e) {
            throw new \RuntimeException($e->getMessage(),$e->getCode(), $e);
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
            return (string) $this->smarty->fetch($template);
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

        $smartyExtParams = [
            '_smarty_debugging' => $this->smarty->debugging,
            '_smarty_ext_template_base_dir' => $this->getTemplateDir(),
        ];

        if (file_exists($template) && !is_dir($template)) {
            $templateFileBody = strtr($template, [
                $this->extension => '-body' . $this->extension
            ]);
            $smartyExtParams['_smarty_ext_template_path'] = dirname($templateFileBody) . '/';
            $smartyExtParams['_smarty_ext_template_body'] = basename($templateFileBody);
            $smartyExtParams['_smarty_ext_template_file_body'] = $templateFileBody;
            $this->smarty->assign($smartyExtParams);
            return $this->fetch($template);
        }

        if (substr($template, -1 * strlen($this->extension)) != $this->extension) {
            $template .= $this->extension;
        }

        $fullTemplate = $this->getTemplateDir() . '/' .  ltrim($template, '/');

        if (file_exists($fullTemplate)) {
            $templateFileBody = strtr($fullTemplate, [
                $this->extension => '-body' . $this->extension
            ]);
            $smartyExtParams['_smarty_ext_template_path'] = dirname($templateFileBody) . '/';
            $smartyExtParams['_smarty_ext_template_body'] = basename($templateFileBody);
            $smartyExtParams['_smarty_ext_template_file_body'] = $templateFileBody;
            $this->smarty->assign($smartyExtParams);
            return $this->fetch($fullTemplate);
        }

        throw new \RuntimeException(sprintf("Template [%s] not exists", $fullTemplate));
    }
}