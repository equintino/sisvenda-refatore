<?php

namespace _App;

class Company extends Controller
{
    public function list()
    {
        $company = new \Models\Company();

        foreach($company->all() as $datas) {
            $companies[] = $datas->NomeFantasia;
        }
        return print(json_encode($companies));
    }
}
