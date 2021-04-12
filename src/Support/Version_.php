<?php

namespace Source\Support;

class Version
{
    public $version;
    private $file;

    public function __construct()
    {
        $this->file = __DIR__ . "/../../version";
        if(file_exists($this->file)) {
            foreach(file($this->file) as $row) {
                if(!preg_match("/^#/", $row)) {
                    $this->version = $row;
                }
            }
        }
    }

    public function __toString()
    {
        return $this->version ?? "1.0.0";
    }
}
