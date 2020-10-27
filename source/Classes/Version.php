<?php

namespace Source\Classes;

class Version
{
    public $version;
    private $file;

    public function __construct()
    {
        $this->file = __DIR__ . "/../../VERSION";
        if(file_exists($this->file)) {
            $this->version = file($this->file);
        }
    }

    public function __toString()
    {
        return is_array($this->version) ? $this->version[0] : "1.0.0";
    }
}
