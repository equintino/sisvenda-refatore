<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateCadArquivosTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("id");
            $table->int("COD_ARQUIVO,IND_LOCAL,COD_EMPRESA,COD_DOCUMENTO");
            $table->string("NOM_ARQUIVO");
            $table->date("DAT_INCLUSAO");
            $table->int('IND_TIPO');
            $table->string("MIRCR")->nullable();
            $table->varbinary("ARQ_01,ARQ_02")->nullable();
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
