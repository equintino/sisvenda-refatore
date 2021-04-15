<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateClientsTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("ID_PFISICA");
                //$table->string("RasãoSocial",100)->unique();
            $table->string("Nome,CPF")->nullable();
                //$table->string("CNPJ",50)->unique();
            $table->string("Rua,Num,Complemento,CEP,Bairro,Cidade")->nullable();
            $table->string("Sexo,EstCivil,Salário,Bloqueio,Conceito,Revenda,Crédito,ECF")->nullable();
            $table->string("Situação")->default("BOM");
            $table->string("UF",2)->nullable();
            $table->string("TelResid,Celular,Email")->nullable();
                //$table->decimal(18,2)->nullable();
            $table->bool("StatusAtivo")->nullable()->default(1);
            $table->int("IDEmpresa")->default(1);
            $table->int("IDTransportadora")->nullable();
            $table->int("Vendedor")->nullable();
                //$table->tynyint("IND_INTEGRA_SCWEB")->nullable();
            $table->date("DataNasc")->nullable();
            $table->timestamps();
            return $table->run();
        });

        //'DataReg' => string '2020-06-27 11:50:00' (length=19)

        return $schema;
    }

    public function down(string $entity)
    {
        return Schema::dropIfExists($entity, $this->type);
    }
}
