<?php

namespace Controllers;

use Core\Controller;

class Config extends Controller
{
    private $file;

    public function getConfConnection(): ?string
    {
        return $this->dataConnection();
    }

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function setFile(string $file)
    {
        $this->file = parse_ini_file(__DIR__ . $file, true);
    }

    public function type($local): ?string
    {
        return strstr($this->file[$local]["dsn"], ":", true);
    }

    public function address($local): ?string
    {
        return substr(strstr(strstr($this->file[$local]["dsn"], "="), ";", true),1);
    }

    public function database($local): ?string
    {
        return substr(strrchr($this->file[$local]["dsn"], "="), 1);
    }

    public function user($local): ?string
    {
        return $this->file[$local]["user"];
    }

    public function passwd($local)
    {
        $passwd = $this->file[$local]["passwd"];
        return $this->decrypt($passwd);
    }
}
