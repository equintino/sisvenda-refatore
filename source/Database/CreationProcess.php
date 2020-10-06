<?php

namespace Database;

class CreationProcess
{
    private $connectionName;
    private $type;

    public function define(string $name): void
    {
        define("CONF_CONNECTION", $name);
        $this->connectionName = CONF_CONNECTION;
        $this->type = (new \Config\Config())->type();
    }

    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
