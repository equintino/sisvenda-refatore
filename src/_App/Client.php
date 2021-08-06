<?php

namespace _App;

class Client extends Controller
{
    private $loading;

    public function __construct()
    {
        parent::__construct();
        $this->loading = theme("assets/img/loading.png");
    }

    public function init(?array $data): void
    {
        $page = "client";
        $loading = $this->loading;
        $table = filter_input(INPUT_POST, "table", FILTER_SANITIZE_STRIPPED);
        $companyId = filter_input(INPUT_POST, "companyId", FILTER_SANITIZE_STRIPPED);
        $cnpjCpf = filter_input(INPUT_POST, "cnpjCpf", FILTER_SANITIZE_STRIPPED);

        if($table === "PFisica") {
            $dClients = (new \Models\Client())->search([
                "IDEmpresa" => $companyId,
                "CPF" => $cnpjCpf
            ]);
        } else {
            $dClients = (new \Models\LegalPerson())->search([
                "IDEmpresa" => $companyId,
                "CNPJ" => $cnpjCpf
            ]);
        }

        $this->view->setPath("Modals")->render("budget", [ compact("page","loading","dClients","table") ]);
    }

    public function list(array $data)
    {
        foreach($data as $key => $value) {
            $where[$key] = "{$value}";
        }
        if(!empty($where["CNPJ"]) || !empty($where["RasSocial"])) {
            $client = (new \Models\LegalPerson())->search($where);
        } else {
            $client = (new \Models\Client())->search($where);
        }
        $fields = ["Nome", "CPF", "DataNasc", "TelResid", "Celular", "Email", "Rua", "Num", "Complemento", "Bairro", "Cidade", "UF", "CEP", "RasSocial", "CNPJ", "InscEstadual", "ID_PFISICA", "ID_PJURIDICA", "Tel01", "Tel02", "Bloqueio", "Crédito"];
        if(count($client) < 2) {
            foreach($fields as $v) {
                $dataClient[$v] = ($client[0]->$v ?? null);
            }
            return print(json_encode($dataClient));
        }
    }
}
