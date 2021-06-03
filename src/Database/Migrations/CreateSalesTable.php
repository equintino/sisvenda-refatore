<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateSalesTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("IDVenda_NEW");
            $table->int("Pedido");
            $table->int("IDCliente")->nullable();
            $table->string("NomeCliente")->nullable();
            $table->string("CNPJeCPF");
            $table->string("InscEstadual,TipoCliente")->nullable();
            $table->int("TabVenda")->nullable();
            $table->date("DataVenda,HoraVenda")->nullable();
            $table->int("Vendedor")->nullable();
            $table->decimal("Valor",18,4)->nullable();
            $table->int("FormaPagamento,TipoPagamento,TipoEntrega")->nullable();
            $table->decimal("Frete",18,4)->nullable();
            $table->decimal("DescontoPorc",18,4)->nullable();
            $table->decimal("Desconto",18,4)->nullable();
            $table->string("OBS")->nullable();
            $table->int("Controle")->nullable();
            $table->decimal("ValorCheque",18,4)->nullable();
            $table->string("Comprador")->nullable();
            $table->int("Transportadora")->nullable();
            $table->string("Status")->nullable();
            $table->date("VencOrcamento")->nullable();
            $table->int("NFNum")->nullable();
            $table->decimal("DolarHoje",18,4)->nullable();
            $table->decimal("DolarCliente",18,4)->nullable();
            $table->string("Situação")->nullable();
            $table->bool("MONTAGEM,DESATIVO,PAGO,PROPAGANDA")->nullable();
            $table->string("Viavel")->nullable();
            $table->int("IDEMPRESA");
            $table->string("InfoLogin")->nullable();
            $table->bool("VALE")->nullable();
            $table->date("DataEntrega,HoraEntrega")->nullable();
            $table->string("INFOPAGO")->nullable();
            $table->bool("PDV")->nullable();
            $table->int("EQUIP")->nullable();
            $table->string("USUARIO")->nullable();
            $table->bool("SANGRIA")->nullable();
            $table->date("DataCancelado")->nullable();
            $table->decimal("TabComissao",18,2)->nullable();
            $table->decimal("CustoVenda",18,2)->nullable();
            $table->decimal("CreditoUtilizado",18,2)->nullable();
            $table->int("CupomECF")->nullable();
            $table->date("UltimaAlteracao")->nullable();
            $table->int("UserUltimaAlteracao")->nullable();
            $table->bool("FATURAR")->nullable();
            $table->int("ORIGEM")->nullable();
            $table->bool("SemCadastro")->nullable();
            $table->string("NUM_RASTREIOCORREIOS")->nullable();
            $table->string("OBS2")->nullable();
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
