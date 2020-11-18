<?php

namespace Source\Controllers\Traits;

use Source\Config\Config;

trait ConfigTrait
{
    private $config;

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
