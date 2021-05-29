<?php

namespace _App;

class Company extends Controller
{
    public function list()
    {
        $company = new \Models\Company();

        foreach($company->activeAll() as $datas) {
            $companies[$datas->ID] = [
                "NomeFantasia" => $datas->NomeFantasia,
                "CNPJ" => $datas->CNPJ
            ];
        }
        return print(json_encode($companies));
    }
}
