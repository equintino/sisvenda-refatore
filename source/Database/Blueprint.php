<?php

namespace Database;

use Core\Model;

class Blueprint
{
    private $entity;
    private $type;
    private $sql;

    public function __construct(string $entity, string $type)
    {
        $this->entity = $entity;
        $this->type = $type;
        $this->sql = "";
    }

    public function run(): string
    {
        return $this->createIfExists() . "(" . $this->sql 
            . ", " . implode(", ", $this->timestamps) . ")";
    }

    public function createIfExists(): string
    {
        switch($this->type) {
            case "mysql":
                return "CREATE TABLE IF NOT EXISTS " . $this->entity;
                break;
            case "sqlsrv":
                return "if not exists (select * from sysobjects where name='" . $this->entity . "' and xtype='U') CREATE TABLE " . $this->entity;
        }
    }

    public function dropIfExists(): string
    {
        switch($this->type) {
            case "mysql":
                return $this->sql .= "DROP TABLE IF EXISTS " . $this->entity;
            case "sqlsrv":
                return $this->sql .= "if exists (select * from sysobjects where name='" 
                            . $this->entity . "' and xtype='U') DROP TABLE " . $this->entity;
        }
    }

    /** @var string $name */
    public function increment(string $name): string
    {
        switch($this->type) {
            case "mysql":
                return $this->sql .= "{$name} INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
            case "sqlsrv":
                return $this->sql .= "{$name} INT NOT NULL IDENTITY(1,1) PRIMARY KEY";
        }
    }
    
    /** @var string name, @var string $null, @var string $default, */
    public function int(string $name): object
    {
        $this->sql .= ", {$name} INT NOT NULL";

        return $this;
    }

    /** @var string $name, @var int $length, @var string $null, @var string $default */
    public function string(string $name, int $length = 255): object
    {
        $this->sql .= ", {$name} VARCHAR({$length}) NOT NULL";

        return $this;
    }

    /** @var string $name, @var bool $default */
    public function bool(string $name): object
    {
        switch($this->type) {
            case "mysql":
                $boolean = "BOOLEAN";
                break;
            case "sqlsrv":
                $boolean = "BIT";
        }
        $this->sql .= ", {$name} {$boolean} NOT NULL";

        return $this;
    }

    public function nullable(): object
    {
        $end = strripos($this->sql, "NOT NULL");
        $partOne = substr($this->sql, 0, $end);
        $partTwo = substr($this->sql, $end + 4, strlen($this->sql));

        $this->sql = $partOne . $partTwo;

        return $this;
    }

    public function unique(): object
    {
        $this->sql .= " UNIQUE";

        return $this;
    }

    public function default(string $default): object
    {
        $default = is_numeric($default) ? (int) $default : $default;
        $this->sql .= " DEFAULT {$default}";

        return $this;
    }

    public function timestamps(): object
    {
        switch($this->type) {
            case "mysql":
                $default = "CURRENT_TIMESTAMP";
                $type = " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
                break;
            case "sqlsrv":
                $default = "GETDATE()";
                $type = null;
            default:
                $type = null;
            
        }
        $this->timestamps = [
            "created_at DATETIME NOT NULL DEFAULT {$default}",
            "updated_at DATETIME NULL{$type}"
        ];

        return $this;
    }
}
