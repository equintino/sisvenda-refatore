<?php

namespace _App;

class Transport extends Controller
{
    public function list($data)
    {
        $where = [
            "IDEmpresa" => $data["companyId"]
        ];
        $transportDb = (new \Models\Transport())->search($where);

        foreach($transportDb as $data) {
            $transport[] = [
                "IDTransportadora" => $data->IDTransportadora,
                "RasSocial" => $data->RasSocial,
                "Cnpj" => $data->Cnpj,
                "IDEmpresa" => $data->IDEmpresa
            ];
        }
        return print(json_encode($transport));
    }
}
