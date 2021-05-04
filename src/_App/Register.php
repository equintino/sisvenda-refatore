<?php

namespace _App;

use Models\Client;
use Models\Transport;
use Models\Supplier;
use Support\CompanyDataWeb;

class Register extends Controller
{
    public function init(?array $data): void
    {
        $cnpj = null;
        $cpf = null;
        $act = "cad_cliente";
        $page = "CLIENTE";
        $data["act"] = $act;
        $loading = theme("assets/img/loading.png");

        /** conferir utilização */
        /**return Cnpj da transportadora*/
        $selIdTransp = function($id) {
            foreach( $_SESSION["Transportadora"] as $v ) {
                if( $id === $v->IDTransportadora ) {
                    return $v->Cnpj;
                }
            }
        };

        /** Definindo empresa/id Transportadora */
        $transpDb = (new Transport())->all(0);
        if(!empty($transpDb)) {
            foreach ($transpDb as $value) {
                if($value->Cnpj !== "" || $value->RasSocial === "SEM FRETE") {
                    $transp[$value->Cnpj] = array(
                        'RasSocial' => $value->RasSocial,
                        'IDEmpresa' => $value->IDEmpresa,
                        "Cnpj" => $value->Cnpj,
                        "IDTransportadora" => $value->IDTransportadora
                    );
                }
            }
        }
        $transp = ($transp ?? null);

        /** Seleção do tipo do formulário */
        echo "<script>var identification = 'CADASTRO DE {$page}';</script>";
        if(isset($cnpj)) {
            echo "<script>cnpj = {$cnpj};</script>";
        }
        if(isset($cpf)) {
            echo "<script>cpf = {$cpf};</script>";
        }

        $identCnpj = array('CNPJ', 'NomeFantasia', 'RasSocial', 'Tel01', 'Email',
        'Atividade', 'StatusAtivo', 'InscEstadual', 'HomePage');

        $endCnpj = array('Rua', 'Num', 'Complemento', 'Bairro', 'Cidade', 'UF',
        'CEP');

        $outrosCnpj = array('Vendedor', 'Bloqueio', 'Crédito', 'Revenda',
        'IDTransportadora', 'IDEmpresa', 'ECF', 'LIMITE_CAIXAS', 'Conceito');

        $this->view->insertTheme([ compact("page", "loading") ]);
        $this->view->render("register", [
            compact("act","selIdTransp","transp","identCnpj","endCnpj","outrosCnpj")
        ]);
    }

    public function transport(?array $data): void
    {
        $cnpj = null;
        $cpf = null;
        $act = "cad_trasportadora";
        $page = "TRANSPORTADORA";
        $data["act"] = $act;
        $loading = theme("assets/img/loading.png");

        $identCnpj = array('CNPJ', 'NomeFantasia', 'RasSocial', 'Tel01', 'Email',
        'Atividade', 'StatusAtivo', 'InscEstadual', 'HomePage');

        if( $act === "cad_transportadora" ) {
            $identCnpj[1] = "RasSocial";
            $fantasia = $rasSocial;
        }

        $endCnpj = array('Rua', 'Num', 'Complemento', 'Bairro', 'Cidade', 'UF',
        'CEP');

        $outrosCnpj = array('Vendedor', 'Bloqueio', 'Crédito', 'Revenda',
        'IDTransportadora', 'IDEmpresa', 'ECF', 'LIMITE_CAIXAS', 'Conceito');

        /** page identification */
        echo "<script>var identification = 'CADASTRO DE {$page}';</script>";

        $this->view->insertTheme([ compact("page", "loading") ]);
        $this->view->render("register", [ compact("act","identCnpj","endCnpj","outrosCnpj") ]);
    }

    public function supplier(?array $data): void
    {
        $cnpj = null;
        $cpf = null;
        $act = "cad_fornecedor";
        $page = "FORNECEDOR";
        $data["act"] = $act;
        $loading = theme("assets/img/loading.png");

        $identCnpj = array('CNPJ', 'NomeFantasia', 'RasSocial', 'Tel01', 'Email',
        'Atividade', 'StatusAtivo', 'InscEstadual', 'HomePage');

        $endCnpj = array('Rua', 'Num', 'Complemento', 'Bairro', 'Cidade', 'UF',
        'CEP');

        $outrosCnpj = array('Vendedor', 'Bloqueio', 'Crédito', 'Revenda',
        'IDTransportadora', 'IDEmpresa', 'ECF', 'LIMITE_CAIXAS', 'Conceito');

        /** page identification */
        echo "<script>var identification = 'CADASTRO DE {$page}';</script>";

        $this->view->insertTheme([ compact("page", "loading") ]);
        $this->view->render("register", [ compact("act","identCnpj","endCnpj","outrosCnpj") ]);
    }

    public function load(?array $data)
    {
        $client = new Client();
        $fields = [
            "Nome","DataNasc","TelResid","Celular","Email","Rua","Num","Complemento","Bairro","Cidade","UF","CEP","NomeFantasia","InscEstadual","RasSocial","Tel01","Tel02","qsa","Contato","HomePage","Atividade","StatusAtivo","cep","Sócio01","Cep","IDTransportadora"
        ];

        if(!empty($data["cpf"])) {
            $clientDb = $client->find($data["cpf"]);
        } elseif(!empty($data["cnpj"])) {
            $cnpj = $data["cnpj"];
            $cnpj = substr($cnpj,0,2) . "."
                . substr($cnpj,2,3) . "."
                . substr($cnpj,5,3) . "/"
                . substr($cnpj,8,4) . "-"
                . substr($cnpj,-2);

            $client::$entity = "PJuridica";
            $clientDb = $client->find($cnpj);
        }
        $obj = new \stdClass();
        if(!empty($clientDb)) {
            foreach($fields as $field) {
                if($field === "DataNasc") {
                    $obj->$field = dateFormat($clientDb->$field);
                } else {
                    $obj->$field = $clientDb->$field;
                }
            }
            $obj->buttonText = "Atualizar";
        } elseif(!empty($data["cnpj"])) {
            $clientWeb = new CompanyDataWeb($cnpj);
            $obj = $clientWeb->getDataWeb();
            $obj->buttonText = "Salvar";
            return print(json_encode($obj));
        }
        return print(json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public function loadTransport(?array $data)
    {
        $transport = new Transport();
        $fields = [
           "Nome","DataNasc","TelResid","Celular","Email","Rua","Num","Complemento","Bairro","Cidade","UF","CEP","NomeFantasia","InscEstadual","RasSocial","Tel01","Tel02","qsa","Contato","HomePage","Atividade","StatusAtivo","cep","Sócio01","InscEsdatual"
        ];
        $cnpj = $data["cnpj"];
        $cnpj = substr($cnpj,0,2) . "."
            . substr($cnpj,2,3) . "."
            . substr($cnpj,5,3) . "/"
            . substr($cnpj,8,4) . "-"
            . substr($cnpj,-2);

        $transportDb = $transport->find($cnpj)[0];

        $obj = new \stdClass();
        if(!empty($transportDb)) {
            foreach($fields as $field) {
                $field_ = ($field !== "StatusAtivo" ? $field : "ATIVO");
                $obj->$field = $transportDb->$field_;
            }
            $obj->buttonText = "Atualizar";
        } else {
            $clientWeb = new CompanyDataWeb($cnpj);
            $obj = $clientWeb->getDataWeb();
            $obj->buttonText = "Salvar";
        }
        return print(json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public function loadSupplier(?array $data)
    {
        $supplier = new Supplier();
        $fields = [
            "Nome","DataNasc","TelResid","Celular","Email","Rua","Num","Complemento","Bairro","Cidade","UF","CEP","NomeFantasia","InscEstadual","RasSocial","Tel01","Tel02","qsa","Contato","HomePage","Atividade","StatusAtivo","cep","Sócio01","InscEsdatual","Cep"
        ];
        $cnpj = $data["cnpj"];
        $cnpj = substr($cnpj,0,2) . "."
            . substr($cnpj,2,3) . "."
            . substr($cnpj,5,3) . "/"
            . substr($cnpj,8,4) . "-"
            . substr($cnpj,-2);

        $supplierDb = $supplier->find($cnpj);

        $obj = new \stdClass();
        if(!empty($supplierDb)) {
            foreach($fields as $field) {
                $obj->$field = $supplierDb->$field;
            }
            $obj->buttonText = "Atualizar";
        } else {
            $clientWeb = new CompanyDataWeb($cnpj);
            $obj = $clientWeb->getDataWeb();
            $obj->buttonText = "Salvar";
        }
        return print(json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public function update(array $data): string
    {
        $data = array_filter($data);
        $client = new Client();
        if(!empty($data["CNPJ"])) {
            $search = $data["CNPJ"];
            $client::$entity = "PJuridica";
        } else {
            $search = $data["CPF"];
            $client::$entity = "PFisica";
        }
        $clientDb = $client->find($search);
        if($clientDb) {
            foreach($data as $key => $value) {
                // if($key === "DataNasc") {
                //     $value = dateFormat($value);
                // }
                $clientDb->$key = $value;
            }

            $clientDb->save();
            return print(json_encode($clientDb->message()));
        }
        return print(json_encode("<span class=warning>Registro não encontrado</span>"));
    }

    public function save(array $data): void
    {
        $data = array_filter($data);
        $client = new Client();
        $client::$entity = (!empty($data["CNPJ"]) ? "PJuridica" : "PFisica");
        foreach($data as $key => $value) {
            $client->$key = $value;
        }
        $client->save();
        echo json_encode($client->message());
    }

    public function saveTransport(array $data): void
    {
        $data = array_filter($data);
        $transport = new Transport();
        $transport::$entity = "Transportadora";
        foreach($data as $key => $value) {
            ($key = $key === "InscEstadual" ? "InscEsdatual" : $key);
            $transport->$key = $value;
        }
        $transport->save();
        echo json_encode($transport->message());
    }

    public function updateTransport(array $data): string
    {
        $data = array_filter($data);
        $transport = new Transport();
        $transportDb = $transport->find($data["CNPJ"])[0];
        if($transportDb) {
            foreach($data as $key => $value) {
                ($key = $key === "InscEstadual" ? "InscEsdatual" : $key);
                $transportDb->$key = $value;
            }

            $transportDb->save();
            return print(json_encode($transportDb->message()));
        }
        return print(json_encode("<span class=warning>Registro não encontrado</span>"));
    }

    public function saveSupplier(array $data): void
    {
        $data = array_filter($data);
        $supplier = new Supplier();
        foreach($data as $key => $value) {
            ($key = $key === "InscEstadual" ? "InscEsdatual" : $key);
            $supplier->$key = $value;
        }
        $supplier->save();
        echo json_encode($supplier->message());
    }

    public function updateSupplier(array $data): string
    {
        $data = array_filter($data);
        $supplier = new Supplier();
        $supplierDb = $supplier->find($data["CNPJ"]);
        if($supplierDb) {
            foreach($data as $key => $value) {
                ($key = $key === "InscEstadual" ? "InscEsdatual" : $key);
                $supplierDb->$key = $value;
            }

            $supplierDb->save();
            return print(json_encode($supplierDb->message()));
        }
        return print(json_encode("<span class=warning>Registro não encontrado</span>"));
    }

    public function getIdTransport($data)
    {
        $listIds = [];
        $transport = new Transport();
        $cnpjTransport = $transport->load($data["id"])->Cnpj;
        $transports = $transport->find($cnpjTransport);
        if($transports) {
            foreach($transports as $value) {
                $listIds[] = $value->IDTransportadora;
            }
        }
        return print(json_encode($listIds));
    }

}
