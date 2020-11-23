<?php

namespace Source\Controllers\Traits;

use Source\Config\Config;

trait ConfigTrait
{
    public function config(): Config
    {
        return new Config();
    }
}
