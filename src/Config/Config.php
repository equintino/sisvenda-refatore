<?php

namespace Config;

use Core\Connect;
use Traits\CryptoTrait;

class Config
{
    use CryptoTrait;

    private $file;
    private $data;
    private $dsn;
    private $user;
    private $passwd;
    public $local;
    public $message;

    public function __construct()
    {
        $this->setFile("/.config.ini");
        $this->local = $this->getConfConnection();
    }

    /** contant file env */
    public function getConfConnection(): ?string
    {
        return Connect::getConfConnection();
    }

    public function setConfConnection(string $data, string $connectionName = null)
    {
        parse_str($data, $data);
        $this->local = (!empty($connectionName) ? $connectionName : $data["connectionName"]);
        $this->data = $data;
        $this->setType($this->data["type"]);
        $this->setAddress($this->data["address"]);
        $this->setDatabase($this->data["db"]);
        $this->setUser($this->data["user"]);
        if(!empty($this->data["passwd"])) {
            $this->setPasswd($this->data["passwd"]);
        }
    }

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function setFile(string $file)
    {
        $this->file = parse_ini_file(__DIR__ . $file, true);
    }

    public function type(): ?string
    {
        return strstr($this->file[$this->local]["dsn"], ":", true);
    }

    private function setType(string $type)
    {
        $dsn = "";
        switch($type) {
            case "sqlsrv":
                $dsn .= "sqlsrv:Server=";
                break;
            case "mysql":
                $dsn .= "mysql:host=";
        }
        $this->dsn = $dsn;
    }

    public function address(): ?string
    {
        return substr(strstr(strstr($this->file[$this->local]["dsn"], "="), ";", true),1);
    }

    private function setAddress(string $address)
    {
        $this->dsn .= "{$address};";
    }

    public function database(): ?string
    {
        return substr(strrchr($this->file[$this->local]["dsn"], "="), 1);
    }

    private function setDatabase(string $database)
    {
        if($this->data["type"] === "sqlsrv") {
            $name = "Database";
        }
        elseif($this->data["type"] === "mysql") {
            $name = "dbname";
        }
        $this->dsn .= "{$name}={$database}";
    }

    public function getDsn(): ?string
    {
        return $this->dsn;
    }

    public function user(): ?string
    {
        return $this->file[$this->local]["user"];
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    private function setUser(string $user)
    {
        $this->user = $user;
    }

    public function passwd(): ?string
    {
        $passwd = $this->file[$this->local]["passwd"];
        return $this->decrypt($passwd);
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    private function setPasswd(string $passwd)
    {
        $this->passwd = (!empty($passwd) ? $this->crypt($passwd) : null);
    }

    private function decrypt(?string $passwd): ?string
    {
        return base64_decode($passwd);
    }

    public function confirmSave(): bool
    {
        if(array_key_exists($this->local, $this->file)) {
            $this->message = "<span class=warning >O nome de conexão já existe</span>";
            return false;
        } else {
            return $this->save();
        }
    }

    public function save(string $data): bool
    {
        $file = (object) $this->getFile();
        $this->setConfConnection($data);
        parse_str($data, $data);
        $connectionName = $data["connectionName"];
        if(!empty($file->$connectionName)) {
            $this->message = "<span class='warning'>Nome de conexão já existente</span>";
            return false;
        }

        $file->$connectionName = [
            "dsn" => $this->getDsn(),
            "user" => $this->getUser(),
            "passwd" => $this->getPasswd()
        ];

        $saved = $this->saveFile((array) $file);
        $this->message = ($saved ? "<span class='success'>Dados salvo com sucesso</span>" : "<span class='error'>Erro ao salvar</span>");
        return $saved;
    }

    public function update(array $data): bool
    {
        $file = (object) $this->getFile();
        $this->setConfConnection($data["data"]);
        parse_str($data["data"], $data);
        $connectionName = $data["connectionName"];

        $passwd = $file->$connectionName["passwd"];
        $file->$connectionName = [
            "dsn" => $this->getDsn(),
            "user" => $this->getUser(),
            "passwd" => $passwd
        ];

        $saved = $this->saveFile((array) $file);
        $this->message = ($saved ? "<span class='success'>Dados salvo com sucesso</span>" : "<span class='error'>Erro ao salvar</span>");
        return $saved;
    }

    public function delete(string $connectionName): ?bool
    {
        unset($this->file[$connectionName]);
        if($this->saveFile($this->file)) {
            $this->message = "<span class='success'>Dados excluídos com sucesso</span>";
            return true;
        } else {
            $this->message = "<span class='warnig'>Não foi possível excluir dados</span>";
            return false;
        }
    }

    private function saveFile(array $data): bool
    {
        $file = __DIR__ . "/../Config/.config.ini";
        /** saving file */
        $handle = fopen($file, "r+");
        ftruncate($handle, 0);
        rewind($handle);

        /** replace data */
        $string = "";
        foreach($data as $local => $params) {
            $string .= "[{$local}]\r\n";
            foreach($params as $param => $value) {
                $string .= "{$param}='{$value}'\r\n";
            }
        }

        $resp = fwrite($handle, $string);
        fclose($handle);
        return $resp;
    }

    public function message(): ?string
    {
        return $this->message;
    }
}
