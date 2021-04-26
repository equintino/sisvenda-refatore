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
            $legalPerson->RasSocial = (empty($data->nome) ? null : $data->nome);
            $legalPerson->UF = (empty($data->uf) ? null : $data->uf);
            $telephone = (empty($data->telefone) ? null : trim(strstr($data->telefone, "/", true)));

            $legalPerson->Tel01 = $telephone;

            $partner = !empty($data->qsa) ? $data->qsa[0]->nome : null;
            $legalPerson->Socio01 = $partner;

            $statusAtivo = strtolower($data->status) === "ok" ? "1" : "0";
            $legalPerson->StatusAtivo = $statusAtivo;
            $legalPerson->Situacao = "BOM";
            $legalPerson->Bairro = (empty($data->bairro) ? null : $data->bairro);
            $legalPerson->Rua = (empty($data->logradouro) ? null : $data->logradouro);
            $legalPerson->Num = (empty($data->numero) ? null : $data->numero);
            $legalPerson->CEP = (empty($data->cep) ? null : $data->cep);
            $legalPerson->Cidade = (empty($data->municipio) ? null : $data->municipio);
            $legalPerson->NomeFantasia = (empty($data->fantasia) ? null : $data->fantasia);
            $legalPerson->CNPJ = (empty($data->cnpj) ? null : $data->cnpj);
            $legalPerson->Complemento = (empty($data->complemento) ? null : $data->complemento);
            $legalPerson->Email = (empty($data->email) ? null : $data->email);
            $legalPerson->Atividade = (empty($data->atividade_principal) ? null : $data->atividade_principal[0]->text);
        }

        $this->dataWeb = $legalPerson;
    }
}
