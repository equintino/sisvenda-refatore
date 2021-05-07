<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateSalemansTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("ID_Vendedor");
            $table->string("LogON");
            $table->string("Senha,Nome,Sexo,EstaCivil,CPF,Email")->nullable();
            $table->date("DataNasc")->nullable();
            $table->bool("Gerente")->nullable()->default(0);
            $table->int("USUARIOG")->default(0);
            $table->int("ATIVO")->default(1);
            $table->string("LOGONEMAIL")->nullable();
            $table->int("IDEmpresa")->default(1);
            $table->timestamps();
            return $table->run();
        });
        return $schema;
    }

    public function down(string $entity)
    {
        return Schema::dropIfExists($entity, $this->type);
    }
}
