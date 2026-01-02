<?php

namespace YusamHub\SmartyExt;

use Smarty\Exception;

class SmartyExt
{
    public string $vendorDir;
    public string $extension;
    private array $config;

    private SmartyEngine $smartyEngine;

    /**
     * @param array $config
     * @throws Exception
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

        $this->smartyEngine = new SmartyEngine();
        $this->smartyEngine->setTemplateDir($this->config['smartyDirs']['templateDir']??'');
        $this->smartyEngine->setConfigDir($this->config['smartyDirs']['configDir']??'');
        $this->smartyEngine->setCompileDir($this->config['smartyDirs']['compileDir']??'');
        $this->smartyEngine->setCacheDir($this->config['smartyDirs']['cacheDir']??'');
        //todo: need fix
        //$this->smartyEngine->addExtension();
        /*$this->smartyEngine->addPluginsDir(
            array_merge(
                (array) $this->config['smartyDirs']['pluginDir']??[],
                [
                    __DIR__ . DIRECTORY_SEPARATOR . 'smarty_plugins'
                ]
            )
        );*/
        $configSmarty = $this->config['smarty']??[];
        foreach($configSmarty as $k => $v) {
            if (property_exists($this->smartyEngine, $k)) {
                $this->smartyEngine->{$k} = $v;
            }
        }
        $this->registerPlugins();
    }

    /**
     * @return SmartyEngine
     */
    public function getSmartyEngine(): SmartyEngine
    {
        return $this->smartyEngine;
    }


    /**
     * @throws Exception
     */
    private function registerPlugins(): void
    {
        $this->smartyEngine->registerPlugin('modifier', 'md5', function(string $string) {
            return md5($string);
        });
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getTemplateDir(): string
    {
        $templateDir = $this->smartyEngine->getTemplateDir();
        if (is_array($templateDir) && isset($templateDir[0])) {
            return rtrim($templateDir[0], '/');
        } elseif (is_string($templateDir)) {
            return rtrim($templateDir,'/');
        }
        throw new \Exception("Unable to detect templateDir");
    }

    /**
     * @param string $template
     * @return string
     * @throws Exception
     */
    private function fetch(string $template): string
    {
        return (string) $this->smartyEngine->fetch($template);
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function view(string $template, array $params = []): string
    {
        $this->smartyEngine->assign($params);

        $smartyExtParams = [
            '_smarty_debugging' => $this->smartyEngine->debugging,
            '_smarty_ext_template_base_dir' => $this->getTemplateDir(),
        ];

        if (file_exists($template) && !is_dir($template)) {
            $pathInfo = pathinfo($template);
            $smartyExtParams['_smarty_ext_template_extension'] = $this->extension;
            $smartyExtParams['_smarty_ext_template_path'] = $pathInfo['dirname'] . '/';
            $smartyExtParams['_smarty_ext_template_basename'] = $pathInfo['basename'];
            $smartyExtParams['_smarty_ext_template_file'] = $template;
            $smartyExtParams['_smarty_ext_template_filename'] = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
            $smartyExtParams['_smarty_ext_template_name'] = $pathInfo['filename'];
            $this->smartyEngine->assign($smartyExtParams);
            return $this->fetch($template);
        }

        if (substr($template, -1 * strlen($this->extension)) != $this->extension) {
            $template .= $this->extension;
        }

        $fullTemplate = $this->getTemplateDir() . '/' .  ltrim($template, '/');

        if (file_exists($fullTemplate)) {
            $pathInfo = pathinfo($fullTemplate);
            $smartyExtParams['_smarty_ext_template_extension'] = $this->extension;
            $smartyExtParams['_smarty_ext_template_path'] = $pathInfo['dirname'] . '/';
            $smartyExtParams['_smarty_ext_template_basename'] = $pathInfo['basename'];
            $smartyExtParams['_smarty_ext_template_file'] = $fullTemplate;
            $smartyExtParams['_smarty_ext_template_filename'] = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
            $smartyExtParams['_smarty_ext_template_name'] = $pathInfo['filename'];
            $this->smartyEngine->assign($smartyExtParams);
            return $this->fetch($fullTemplate);
        }

        throw new \Exception(sprintf("Template [%s] not exists", $fullTemplate));
    }
}