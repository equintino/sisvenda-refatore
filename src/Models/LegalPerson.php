<?php

namespace Models;

use Database\Migrations\CreateClientsTable2;

class LegalPerson extends Client
{
    public function __construct()
    {
        static::$entity = "PJuridica";
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
