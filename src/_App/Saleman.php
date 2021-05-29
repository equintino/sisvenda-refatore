<?php

namespace _App;

class Saleman extends Controller
{
    public function load(array $data)
    {
        $saleman = new \Models\Saleman();

        $listSellers = $saleman->search([
                "IDEmpresa" => $data['companyId'],
                "ATIVO" => 1
            ]);

        foreach($listSellers as $saleman) {
            $list[] = [
                "ID_Vendedor" => $saleman->ID_Vendedor,
                "LogON" => $saleman->LogON,
                "IDEmpresa" => $saleman->IDEmpresa
            ];
        }
        return print(json_encode($list));
    }
}
