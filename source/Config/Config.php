<?php

namespace Config;

class Config
{
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
        return \Core\Connect::getConfConnection();
    }

    public function setConfConnection(string $connectionName, string $data)
    {
        parse_str($data, $data);
        $this->local = (!empty($connectionName) ? $connectionName : $data["connectionName"]);
        $this->data = $data;
        $this->setType($this->data["type"]);
        $this->setAddress($this->data["address"]);
        $this->setDatabase($this->data["database"]);
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

    public function setType(string $type)
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

    public function setAddress(string $address)
    {
        $this->dsn .= "{$address};";
    }

    public function database(): ?string
    {
        return substr(strrchr($this->file[$this->local]["dsn"], "="), 1);
    }

    public function setDatabase(string $database)
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

    public function setUser(string $user)
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

    public function setPasswd(string $passwd)
    {
        $this->passwd = (!empty($passwd) ? base64_encode($passwd) : null);
    }

    private function decrypt(?string $passwd): ?string
    {
        return base64_decode($passwd);
    }

    public function confirmSave(): bool
    {
        if(array_key_exists($this->local, $this->file)) {
            $this->message = "<span class=warning >O nome de conexão já existe</span>";
            return false
        }
        else {
            return $this->save();
        }
    }

    public function save(): bool
    {
        $this->file[$this->local] = [
            "dsn" => $this->getDsn(),
            "user" => $this->getUser(),
            "passwd" => $this->getPasswd()
        ];

        $saved = $this->saveFile($this->file);
        $this->message = ($saved ? "<span class='success'>Dados salvo com sucesso</span>" : "<span class='error'>Erro ao salvar</span>");
        return $saved;
    }

    public function delete(string $connectionName): ?bool
    {
        unset($this->file[$connectionName]);
        return $this->saveFile($this->file);
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

    public function message(): string
    {
        return $this->message;
    }
}
