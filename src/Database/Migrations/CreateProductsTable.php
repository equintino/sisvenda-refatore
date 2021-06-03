<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateProductsTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("IdxProd");
            $table->int("Pedido");
            $table->string("IDProduto");
            $table->int("Item")->nullable();
            $table->string("Descrição")->nullable();
            $table->decimal("Quantidade",18,4)->nullable();
            $table->string("UniMedida")->nullable();
            $table->decimal("Desconto,Valor,CustoProd,ValorProdReal",18,4)->nullable();
            $table->decimal("Comissão",18,4)->nullable();
            $table->date("DATAREG")->nullable();
            $table->bool("TemSerial,TemGrade,TemLote,Consignado,Entregue")->nullable();
            $table->string("IDMATERIAL")->nullable();
            $table->int("IDEmpresa");
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
