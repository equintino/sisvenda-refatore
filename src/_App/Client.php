<?php

namespace _App;

use Traits\OpenDataTableDb;

class Client extends Controller
{
    use OpenDataTableDb;
    private $loading;
    static public $exceptColumns = ["TipoCliente"];

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
        echo "<script>var IDEmpresa = '{$companyId}'</script>";

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

    public function getClient(array $data)
    {
        if(!empty($data["CNPJ"]) || !empty($data["RasSocial"])) {
            $client = (new \Models\LegalPerson())->search($data);
        } else {
            $client = (new \Models\Client())->search($data);
        }
        $dataFound = count($client);
        $fields = ["Nome", "CPF", "DataNasc", "TelResid", "Celular", "Email", "Rua", "Num", "Complemento", "Bairro", "Cidade", "UF", "CEP", "RasSocial", "CNPJ", "InscEstadual", "ID_PFISICA", "ID_PJURIDICA", "Tel01", "Tel02", "Bloqueio", "Crédito"];
        if($dataFound < 2) {
            if($dataFound === 0) {
                return print(json_encode("Nenhum registro foi encontrado"));
            }
            foreach($fields as $v) {
                $dataClient[$v] = ($client[0]->$v ?? null);
            }
        } else {
            return (print(json_encode($dataFound)));
        }
        return print(json_encode($dataClient));
    }

    public function view(array $data)
    {
        // foreach($data["data"] as $k => $v) {
        //     $$k = $v;
        // }
        if(!empty($RasSocial) || !empty($CNPJ)) {
            //static::$entity = "PJuridica";
            $client = new \Models\Client();
        } else {
            //static::$entity = "PFisica";
            $client = new \Models\LegalPerson();
        }
        $search = array_filter($data["data"]);
        $datas = $client->search($search);
        //var_dump($datas);

        return $this->view->setPath("Modals")->render("table", [ compact("datas") ]);
        var_dump($dClient);die;

        $this->requestData = $data;
        $searchArr = [];
        $where = "";

        $paramsDataTable = [ "draw", "columns", "order", "start", "length", "search" ];

        $searchArr = $this->searchArr($this->requestData, static::$entity);
        $sql = "SELECT * FROM " . static::$entity . " WHERE 1=1 ";

        if(!empty($searchArr)) {
            $sql .= $this->validate($searchArr);
        }

        if(!empty($this->requestData["search"]["value"])) {
            $sql .= $this->whereDataTable($this->requestData);
        }

        $recordsTotal = $this->getTotalRows($sql, static::$entity);

        if(!empty($this->requestData["order"])) {
            $sql .= $this->orderDataTable($this->requestData, intVal($this->requestData['start']), intVal($this->requestData['length']));
        }

        //$datas = $this->getData($sql, $searchArr, $this->requestData["columns"]);
        var_dump($data);
    }

    public function list(array $data)
    {
        //$this->view->render("config");
        static::$entity = "PJuridica";
        $this->requestData = $data;
        $searchArr = [];
        $where = "";

        $paramsDataTable = [ "draw", "columns", "order", "start", "length", "search" ];

        $searchArr = $this->searchArr($this->requestData, static::$entity);
        $sql = "SELECT * FROM " . static::$entity . " WHERE 1=1 ";

        if(!empty($searchArr)) {
            $sql .= $this->validate($searchArr);
        }

        if(!empty($this->requestData["search"]["value"])) {
            $sql .= $this->whereDataTable($this->requestData);
        }

        $recordsTotal = $this->getTotalRows($sql, static::$entity);

        if(!empty($this->requestData["order"])) {
            $sql .= $this->orderDataTable($this->requestData, intVal($this->requestData['start']), intVal($this->requestData['length']));
        }

        /* Seller's Data */
        // $salemanDb = new \Models\Saleman();
        // foreach($salemanDb->activeAll() as $saleman) {
        //     $dataSaleman[$saleman->ID_Vendedor] = [
        //         "LogON" => $saleman->LogON,
        //         "Nome" => $saleman->Nome,
        //         "IDEmpresa" => $saleman->IDEmpresa
        //     ];
        // }

        $datas = $this->getData($sql, $searchArr, $this->requestData["columns"]);
        return print($this->getJson($datas, $recordsTotal));
    }

    /** Change column name */
    public function changeColumn(string $column): string
    {
        if(static::$entity === "PJuridica") {
            $name = "RasSocial";
            $id = "ID_PJURIDICA";
            $cnpjCpf = "CNPJ";
        } else {
            $name = "Nome";
            $id = "ID_PJURIDICA";
            $cnpjCpf = "CPF";
        }
        $columns = [
            "NomeCliente" => $name,
            "IDCliente" => $id,
            "CNPJeCPF" => $cnpjCpf,
            "IDEMPRESA" => "IDEmpresa"
        ];
        return ($columns[$column] ?? $column);
    }

    public function getColumnsDb($data, $entity): array
    {
        $name = ($entity === "PFisica" ? "Nome" : "RasSocial");
        return [
                "NomeCliente" => $name
            ];
    }

    private function whereDataTable($data): string
    {
        $where   = " AND ";
        $search  = $data["search"]["value"];
        $columns = $data["columns"];
        for($x = 0; $x < count($columns); $x++) {
            if($columns[$x]["searchable"] != "false" && !in_array($columns[$x]["data"], static::$exceptColumns)) {
                $where .= " " . $columns[$x]["data"] . " LIKE '" . $search . "%' OR";
            }
        }
        /** Remove ultimo OR */
        $where = substr($where, 0,strripos($where, "OR"));
        return $where;
    }

    public function getTotalRows($sql, $entity): int
    {
        if($entity === "PJuridica") {
            $client = new \Models\LegalPerson();
        } else {
            $client = new \Models\Client();
        }
        $sql = str_replace("*","1",$sql);
        $tRows = count($client->readDataTable($sql)->fetchAll());

        /** create the file or recreate with the total rows */
        // $logon = $_SESSION["login"]->Logon;
        // $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "w+");
        // fwrite($handle, $tRows);
        // fclose($handle);

        return $this->tRows = $tRows;
    }

    public function getData(string $sql, array $searchArr, array $columns=null): array
    {
        if(static::$entity === "PJuridica") {
            $client = new \Models\LegalPerson();
        } else {
            $client = new \Models\Client();
        }
        //$dataDb = $client->readDataTable($sql, $searchArr);
        $dataDb = $client->readDataTable($sql);

        $datas = [];
        foreach($columns as $column) {
            if(!empty($column["data"]) && !in_array($column["data"], static::$exceptColumns)) {
                $columnNames[] = $this->changeColumn($column["data"]);
            }
        }

        /** open the file */
        // $logon = $_SESSION["login"]->Logon;
        // $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "a");
        // $row = 0;

        if(!empty($dataDb)) {
            foreach($dataDb as $dClient) {
                foreach($columnNames as $columnName) {
                    $d[$columnName] = $dClient->$columnName;//$this->formatColumn($columnName, $dVenda->$columnName);
                }
                //$d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
                //$d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
                //$d["Documentos"] = $this->getImage($dVenda);
                //$d["Produto"] = $this->getProduct($dVenda);
                $datas[] = $d;

                /** save the rows separeted by commas */
                // fwrite($handle, "," . $row++);
                // $percent = ($row * 100) / $this->tRows;
                // setcookie("row", $row, time() + (86400 * 30), "/");
            }
        }
        // fclose($handle);
        return $datas;
    }

    private function formatColumn(string $columnName, $value)
    {
        // if(!isset($Status)) {
        //     $status = new Status();
        // }
        //$sitList = $this->requestData["sitList"];
        //$stsList = $this->requestData["stsList"];

        switch($columnName) {
            case "Pedido":
                $valueFormated = "<span data-pedido='{$value}'>{$value}</span>";
                break;
            case "IDEMPRESA":
                $valueFormated = "<span data-idEmpresa='{$value}'>{$value}</span>";
                break;
            case "Controle": case "NFNum":
                $valueFormated = "<input type=text name='{$columnName}' value='{$value}' size=6 />";
                break;
            case "DataVenda":
                $date = new \DateTime($value);
                $valueFormated = $date->format("d/m/Y");
                break;
            case "HoraVenda":
                $date = new \DateTime($value);
                $valueFormated = $date->format("H:i");
                break;
            case "VencOrcamento":
                $date = new \DateTime($value);
                $value = $date->format("Y-m-d");
                $validate = strtotime($value) - strtotime(date("Y-m-d"));
                $dateExpired = $validate < 0 ? "style='color:red'" : null;
                $valueFormated = "<input type=date name='{$columnName}' value='{$value}' size=6 {$dateExpired} />";
                break;
            case "Vendedor":
                $saleman = new \Models\Saleman();
                if(!empty($value)) {
                    $valueFormated = ($saleman->load($value)->LogON ?? "----");
                } else {
                    $valueFormated = "----";
                }
                break;
            case "Situação":
                $optionSituacao  = "<select name='Situação'>";
                foreach($sitList as $stage) {
                    $selected = ($value === $stage) ? "selected" : null;
                    $optionSituacao .= "<option value='{$stage}' {$selected} >{$stage}</option>";
                }
                $optionSituacao .= "</select>";
                $valueFormated = $optionSituacao;
                break;
            case "DESATIVO":
                $checked = $value == 1 ? "checked" : null;
                $valueFormated = "<input type=checkbox name=DESATIVO {$checked}/>";
                break;
            case "PAGO":
                $checked = $value == 1 ? "checked" : null;
                $valueFormated = "<input type=checkbox name=PAGO {$checked}/>";
                break;
            case "Valor": case "TabComissao":
            case "CreditoUtilizado": case "Frete":
                $valueFormated = number_format($value, "2",",",".");
                break;
            case "NUM_RASTREIOCORREIOS":
                $valueFormated = "<input type=text name='{$columnName}' value='{$value}' size=10 />";
                break;
            case "Status":
                $optionStatus  = "<select name='Status'>";
                foreach($stsList as $sts) {
                    $selected = $value === $sts["value"] ? "selected" : null;
                    $optionStatus .= "<option value='" . $sts["value"] ."' {$selected} >" . $sts["name"] . "</option>";
                }
                $optionStatus .= "</select>";
                $valueFormated = $optionStatus;
                break;
            case "CustoVenda":
                $value = number_format($value, "2",",",".");
                $valueFormated = "<input type=text name=CustoVenda value='{$value}' size=8 style='color: red' />";
                break;
            case "ORIGEM":
                $valueFormated = $value === null ? "INTERNO" : "EXTERNO";
                break;
            default:
                $valueFormated = $value;
        }
        return $valueFormated;
    }

    public function getJson($datas, $recordsTotal)
    {
        if(isset($datas)) {
            $rowCount = count($datas);
        }
        $jsonData = array(
            "draw" => intVal($this->requestData["draw"]),
            "recordsTotal" => intVal($rowCount),
            "recordsFiltered" => intVal($recordsTotal),
            "data" => $datas
        );
        return json_encode($jsonData);
    }
}
