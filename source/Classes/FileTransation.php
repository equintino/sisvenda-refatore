<?php

namespace Source\Classes;

class FileTransation
{
    private $file;
    public $local;

    public function __construct(string $file = ".env")
    {
        $this->file = __DIR__ . "/../../{$file}";
        if(!file_exists($this->file)) {
            $handle = fopen($this->file, "w+");
            $this->local = ( !fwrite($handle, "CONF_CONNECTION=") ? false : true );
            fclose($handle);
        }
    }

    public function getLocal(): ?bool
    {
        return $this->local;
    }

    public function setLocal(string $connectionName)
    {
        define("CONF_CONNECTION", $connectionName);
        $handle = fopen($this->file, "r+b");
        $string = "";
        while($row = fgets($handle)) {
            if(preg_match("/CONF_CONNECTION/", $row)) {
                $string .= "CONF_CONNECTION=" . $connectionName . "\r\n";
            }
            else {
                $string .= $row;
            }
        }

        ftruncate($handle, 0);
        rewind($handle);
        $this->local = ( !fwrite($handle, $string) ? false : true );
        fclose($handle);

        return $this;
    }

    public function saveFile()
    {
        $file = __DIR__ . "/../../.env";
        $handle = fopen($file, "r+b");
        $string = "";
        while($row = fgets($handle)) {
            $parter = key($params);
            if(preg_match("/$parter/", $row)) {
                $string .= $parter . "=" . $params[$parter];
            }
            else {
                $string .= $row;
            }
        }

        ftruncate($handle, 0);
        rewind($handle);
        if(!fwrite($handle, $string)) {
            die("Não foi possível alterar o arquivo.");
        }
        else {
            echo json_encode("Arquivo alterado com secesso!");
        }
        fclose($handle);
    }

    public function getConst(): void
    {
        $handle = fopen($this->file, "r");
        while($row = fgets($handle)) {
            if(!empty(trim($row))) {
                $params = explode("=", trim(str_replace("\"","", $row)));
                if(!defined($params[0])) {
                    define($params[0], "{$params[1]}");
                }
            }
        }
    }
}
