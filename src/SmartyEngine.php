<?php

namespace YusamHub\SmartyExt;
class SmartyEngine extends \Smarty\Smarty
{
    protected array $linkedValue = [];

    /**
     * @param string $key
     * @return mixed
     */
    public function getLinkedValue(string $key)
    {
        return $this->linkedValue[$key];
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setLinkedValue(string $key, $value): void
    {
        $this->linkedValue[$key] = $value;
    }



}