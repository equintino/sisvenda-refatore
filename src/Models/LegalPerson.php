<?php

namespace Models;

use Database\Migrations\CreateClientsTable2;

class LegalPerson extends Client
{
    public function __construct()
    {
        parent::__construct();
        static::$entity = "PJuridica";
    }

    public function readDataTable(string $sql)
    {
        return $this->read($sql);
    }

    public function search(array $where)
    {
        $terms  = "";
        $params = "";
        foreach(array_filter($where) as $k => $v) {
            $signal = (strpos($v, "%") ? "LIKE" : "=");
            $terms  .= " {$k} {$signal} :{$k} AND";
            $params .= "{$k}={$v}&";
        }
        $terms = substr($terms, 0, -3);
        $params = substr($params, 0, -1);
        $data = $this->read("SELECT * FROM " . self::$entity . " WHERE {$terms} ", $params);
        return $data->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function createThisTable()
    {
        $sql = (new CreateClientsTable2())->up(self::$entity);
        return $this->createTable($sql);
    }

    public function dropThisTable()
    {
        $sql = (new CreateClientsTable2())->down(self::$entity);
        return $this->dropTable($sql);
    }
}
