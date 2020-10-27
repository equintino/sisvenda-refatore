<?php

namespace Source\Config;

class GlobalEnv extends Config
{
    public $local;

    public function getLocal(): ?bool
    {
        return $this->local;
    }

    public function setLocal(string $connectionName)
    {
        define("CONF_CONNECTION", $connectionName);
        $file = __DIR__ . "/../../.env";
        $handle = fopen($file, "r+b");
        $string = "";
        while($row = fgets($handle)) {
            if(preg_match("/CONF_CONNECTION/", $row)) {
                $string .= "CONF_CONNECTION=" . $connectionName;
            }
            else {
                $string .= $row;
            }
        }

        ftruncate($handle, 0);
        rewind($handle);
        $this->local = ( !fwrite($handle, $string) ? false : true );
        fclose($handle);
    }
}
