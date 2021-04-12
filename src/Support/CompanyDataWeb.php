<?php

namespace Support;

use Models\LegalOerson;
use \stdClass;

class CompanyDataWeb
{
    private $dataWeb;

    public function __construct($cnpj)
    {
        $this->setDataWeb($cnpj);
    }

    public function getDataWeb()
    {
        return $this->dataWeb;
    }

    public function setDataWeb($cnpj)
    {
        $cnpj = preg_replace("/[\.\/-]/", "", $cnpj);

        $ch = curl_init("https://www.receitaws.com.br/v1/cnpj/" . $cnpj);

        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        $this->setObject(json_decode($output));
    }

    private function setObject($data)
    {
        $legalPerson = new stdClass();

        if(!empty($data)) {
            $legalPerson->RasSocial = $data->nome;
            $legalPerson->UF = $data->uf;
            $telephone = trim(strstr($data->telefone, "/", true));

            $legalPerson->Tel01 = $telephone;

            $partner = !empty($data->qsa) ? $data->qsa[0]->nome : null;
            $legalPerson->Socio01 = $partner;

            $statusAtivo = strtolower($data->status) === "ok" ? "1" : "0";
            $legalPerson->StatusAtivo = $statusAtivo;
            $legalPerson->Situacao = "BOM";
            $legalPerson->Bairro = $data->bairro;
            $legalPerson->Rua = $data->logradouro;
            $legalPerson->Num = $data->numero;
            $legalPerson->CEP = $data->cep;
            $legalPerson->Cidade = $data->municipio;
            $legalPerson->NomeFantasia = $data->fantasia;
            $legalPerson->CNPJ = $data->cnpj;
            $legalPerson->Complemento = $data->complemento;
            $legalPerson->Email = $data->email;
            $legalPerson->Atividade = $data->atividade_principal[0]->text;
        }

        $this->dataWeb = $legalPerson;
    }
}
