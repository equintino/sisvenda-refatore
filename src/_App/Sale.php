<?php

namespace _App;

class Sale extends Controller
{
    private $requestData;
    public $tRows;

    public function __contruct()
    {
        parent::__construct();
    }

    public function init(array $data)
    {
        $this->requestData = $data;
        $searchArr = [];
        $where = "";

        $statusOpt = [ "V", "S", "O", "C", "CO" ];
        $paramsDataTable = [ "draw", "columns", "order", "start", "length", "search" ];

        $searchArr = $this->searchArr($data);
        $sql = (empty($data["status"]) ? "SELECT * FROM Venda where  Status!='C' AND Status!='CO' " : "SELECT * FROM Venda where  1=1 ");

        if(!empty($searchArr)) {
            $sql .= $this->validate($searchArr);
        }

        if(!empty($data["search"]["value"])) {
            $sql .= $this->whereDataTable($data);
        }

        $recordsTotal = $this->getTotalRows($sql);

        if(!empty($data["order"])) {
            $sql .= $this->orderDataTable($data, intVal($data['start']), intVal($data['length']));
        }

        /* Seller's Data */
        $salemanDb = new \Models\Saleman();
        foreach($salemanDb->activeAll() as $saleman) {
            $dataSaleman[$saleman->ID_Vendedor] = [
                "LogON" => $saleman->LogON,
                "Nome" => $saleman->Nome,
                "IDEmpresa" => $saleman->IDEmpresa
            ];
        }

        $datas = $this->getData($sql, $searchArr, $data["columns"]);
        return print($this->getJson($datas, $recordsTotal));
    }

    public function getTotalRows($sql): int
    {
        $sale = new \Models\Sale();
        $sql = str_replace("*","1",$sql);
        $tRows = count($sale->readDataTable($sql)->fetchAll());

        /** create the file or recreate with the total rows */
        $logon = $_SESSION["login"]->Logon;
        $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "w+");
        fwrite($handle, $tRows);
        fclose($handle);

        return $this->tRows = $tRows;
    }

    public function getData(string $sql, array $searchArr, array $columns=null): array
    {
        $sale = new \Models\Sale();
        $dataDb = $sale->readDataTable($sql, $searchArr);
        $datas = [];
        $exceptions = [ "Arquivos","Documentos","Produto" ];
        foreach($columns as $column) {
            if(!empty($column["data"]) && !in_array($column["data"], $exceptions)) {
                $columnNames[] = $column["data"];
            }
        }

        /** open the file */
        $logon = $_SESSION["login"]->Logon;
        $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "a");
        $row = 0;

        //$rowsTotal = getTotalRows($sql);

        //while($dVenda = $query->fetch()) {
        if(!empty($dataDb)) {
            foreach($dataDb as $dVenda) {
                foreach($columnNames as $columnName) {
                    $d[$columnName] = $this->formatColumn($columnName, $dVenda->$columnName);
                }
                //$d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
                $d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
                $d["Documentos"] = $this->getImage($dVenda);
                $d["Produto"] = $this->getProduct($dVenda);
                $datas[] = $d;

                /** save the rows separeted by commas */
                fwrite($handle, "," . $row++);
                $percent = ($row * 100) / $this->tRows;
                setcookie("row", $row, time() + (86400 * 30), "/");
            }
        }
        fclose($handle);
        return $datas;
    }

    public function update()
    {
        $dataPost = json_decode(filter_input(INPUT_POST, "change", FILTER_DEFAULT));

        //$search = criterioBusca();
        //$search->setTabela("Venda");

        //$columnNames = [ "Controle","NFNum","VencOrcamento","CustoVenda","DESATIVO","PAGO","Status","Situação","NUM_RASTREIOCORREIOS","OBS" ];

        $dataSale = [];
        $dataSave = [];
        $saleDb = new \Models\Sale();

        foreach($dataPost as $changeSale) {
            $salesOrder = $changeSale->salesOrder;
            $companyId = $changeSale->companyId;
            if(!preg_match("/^[anexo]/", $changeSale->name)) {
                $dataSale[$salesOrder][$companyId][$changeSale->name] = $changeSale->value;
            } else {
                // $rowFile = $_FILES[substr($changeSale->name,0,-2)];
                // var_dump(
                //     $_FILES,
                //     $rowFile
                // );die;

                $fileData = $_FILES;
                foreach($changeSale->value as $name) {
                    $fileRegistration = new \Models\FileRegistration;
                    $dataSale[$salesOrder][$companyId]["file"][] = $fileRegistration->fileSave($name, $fileData, $companyId, $salesOrder);

                    // $indice = array_search($name,$_FILES[substr($changeSale->name,0,-2)]["name"]);
                    // $tmp_name = $_FILES[substr($changeSale->name,0,-2)]["tmp_name"][$indice];
                    // $type = $_FILES[substr($changeSale->name,0,-2)]["type"][$indice];
                    // $size = $_FILES[substr($changeSale->name,0,-2)]["size"][$indice];

                    // var_dump(
                    //     $_FILES,
                    //     $name,
                    //     $tmp_name,
                    //     $type,
                    //     $size,
                    //     $changeSale
                    // );
                }
            }
            $dataSale[$salesOrder][$companyId]["Pedido"] = $salesOrder;
            $dataSale[$salesOrder][$companyId]["IDEMPRESA"] = $companyId;
        }
        $salesOrders = array_keys($dataSale);
        for($x=0; $x < count($salesOrders); $x++) {
            foreach($dataSale[$salesOrders[$x]] as $companyId => $values) {
                /** search from database */
                $where = [
                    "IDEMPRESA" => $companyId,
                    "Pedido" => $salesOrders[$x]
                ];
                $sale = $saleDb->search($where);
                if(!empty($sale)) {
                    $sale = $sale[0];
                    foreach($values as $columnName => $value) {
                        if($columnName === "CustoVenda") {
                            $value = formatReal($value);
                        }
                        $sale->$columnName = $value;
                    }
                    $sale->save();
                }
            }
        }
        // if(preg_match("/^[anexo]/", $changeSale->name)) {
        //     //$dataSale[$salesOrder]["file"] = $changeSale->value;
        //     $fileRegistration = new \Models\FileRegistration;
        //     foreach($_FILES as $k => $fileData) {
        //         for($x=0; $x < count($fileData["name"]); $x++) {
        //             $dataSale[$salesOrder]["file"] = $fileRegistration->fileSave($fileData, $companyId, $salesOrder);
        //         }
        //     }
        // }
        return print(json_encode($dataSale));

    }

    public function delete($data): string
    {
        $companyId  = $data["companyId"];
        $salesOrder = $data["salesOrder"];
        $sale = (new \Models\Sale())->search([
                                        "Pedido"    => $salesOrder,
                                        "IDEmpresa" => $companyId
                                    ])[0];
        $sale->destroy();
        return print(json_encode($sale->message()));
    }

    private function whereDataTable($data): string
    {
        $except  = ["Documentos", "Arquivos", "Produto"];
        $where   = " AND ";
        $search  = $data["search"]["value"];
        $columns = $data["columns"];
        for($x = 0; $x < count($columns); $x++) {
            if($columns[$x]["searchable"] != "false" && !in_array($columns[$x]["data"], $except)) {
                $where .= " " . $columns[$x]["data"] . " LIKE '" . $search . "%' OR";
            }
        }
        /** Remove ultimo OR */
        $where = substr($where, 0,strripos($where, "OR"));
        return $where;
    }

    public function searchArr($data): array
    {
        $searchArr = [];
        $columnsDb = $this->getColumnsDb($data);
        $pago      = filter_input(INPUT_POST, "pago");
        foreach($data as $key => $value) {
            if(array_key_exists($key, $columnsDb) && $value != "") {
                $value = $key === "pg" ? $pago : $value;
                $searchArr[$columnsDb[$key]] = $value;
            }
        }
        return $searchArr;
    }

    // public function where($searchArr)
    // {
    //     $where = $this->validate($searchArr);
    //     // if(!array_key_exists("Status", $searchArr)) {
    //     //     $where .= "(";
    //     //     foreach($statusOpt as $opt) {
    //     //         $where .= " Status = '" . $opt . "' OR";
    //     //     }
    //     //     /** Remove last OR */
    //     //     $where = substr($where, 0,strripos($where, "OR "));
    //     //     $where .= ")";
    //     // } else {
    //         $where = substr($where, 0,strripos($where, "AND"));
    //     //}
    //     return $where;
    // }

    public function orderDataTable($data, $offset, int $rows): ?string
    {
        $pages = null;
        $order = " ORDER BY " . $this->getFilterColumns($data) . " " . $data['order'][0]['dir'] . " ";
        $pages = " OFFSET {$offset} ROW FETCH NEXT {$rows} ROWS ONLY ";

        return $order . $pages;
    }

    public function getFilterColumns($data): string
    {
        return $data["columns"][$data["order"][0]["column"]]["data"];
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

    public function getColumnsDb($data): array
    {
        $typeSearch = $data["tBusca"] ?? null;
        return [
                "busca" => $typeSearch, "pg" => "PAGO", "desativado" => "DESATIVO",
                "status" => "Status", "companies" => "IDEmpresa", "saleman" => "Vendedor",
                "situacao" => "Situação", "activeSale" => "DataCancelado", "dtInicio" => "dtInicio",
                "dtFim" => "dtFim"
            ];
    }

    private function getImage($data): ?string
    {
        $imageId = "";
        $codDoc = $data->Pedido;
        $fileRegistration = new \Models\FileRegistration();
        $search = [
            "COD_DOCUMENTO" => $data->Pedido,
            "COD_EMPRESA" => $data->IDEMPRESA,
            "IND_LOCAL" => 5
        ];
        $fileList = $fileRegistration->search($search);
        if(!empty($fileList)) {
            foreach($fileList as $file) {
                $cod = $file->COD_ARQUIVO;

                $link = "<a id='{$cod}' style='text-decoration: none; cursor: pointer; color: blue' onclick='openDoc({$cod}, {$codDoc})'><i class='fa fa-file'></i>{$cod}</a>";
                $imageId .= $link . " ";
            }
        }
        return ($imageId ?? null);
    }

    private function getProduct($data, $columns = null): ?array
    {
        return null;
        $columns = [ "Item","IDProduto","Descrição","UniMedida","Quantidade","Valor" ];
        $search = new Dao\CriterioBusca();
        $product = new Controller\ProdutoVendaController();
        $search->setArray(
            array(
                "Pedido" => $data->Pedido,
                "IDEmpresa" => $data->IDEMPRESA
            )
        );
        $search->setTop(0);
        $productDb = $product->find($search)->getAll();
        if(!empty($productDb)) {
            foreach($productDb as $product) {
                //$codeProduct = $product->getArray()["IDProduto"];
                $item = $product->getArray()["Item"];
                foreach($columns as $column) {
                    $detProducts[$item][$column] = $product->getArray()[$column];
                }
            }
        }

        return isset($detProducts) ? $detProducts : null;
    }

    private function formatColumn(string $columnName, $value)
    {
        // if(!isset($Status)) {
        //     $status = new Status();
        // }
        $sitList = $this->requestData["sitList"];
        $stsList = $this->requestData["stsList"];

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

    private function validate($searchArr): ?string
    {
        $where = "";
        foreach($searchArr as $key => $value) {
            if($value !== "") {
                if($key === "DataCancelado") {
                    $where .= $value == 1 ?
                        " AND {$key} is null " : " AND {$key} is not null ";
                } elseif($key === "DESATIVO") {
                    $where .= " AND {$key} = 1 ";
                } elseif($key === "dtInicio") {
                    $where .= " AND DataVenda >= '{$value}' ";
                } elseif($key === "dtFim") {
                    $where .= " AND DataVenda <= '{$value}' ";
                } else {
                    $signal = preg_match('/^%|%$/', $value) ?
                        "LIKE" : "=";
                    $where .= " AND {$key} {$signal} '{$value}' ";
                }
            }
        }
        return $where;
    }
}

// require __DIR__ . "/../../vendor/autoload.php";

// use Database\Connect;
// use Classes\Situation;
// use Classes\Status;

// $requestData = $_REQUEST;
// $tBusca = filter_input(INPUT_POST, "tBusca");
// $dPost = filter_input_array(INPUT_POST);
// $columnsDb = [
//     "busca" => $tBusca, "pg" => "PAGO", "desativado" => "DESATIVO",
//     "status" => "Status", "IDEmpresa" => "IDEmpresa", "vendedor" => "Vendedor",
//     "situacao" => "Situação", "vAtiva" => "DataCancelado", "dtInicio" => "dtInicio",
//     "dtFim" => "dtFim"
// ];
// /** Busca solicitadas pelo dataTable */
// $filterColumns = "Pedido,Controle,NFNum,NomeCliente,CNPJeCPF,DataVenda,HoraVenda,VencOrcamento,Vendedor,Situação,DESATIVO,PAGO,Valor,Status,CustoVenda,TabComissao,CreditoUtilizado,Frete,NUM_RASTREIOCORREIOS,ORIGEM,IDCliente,TipoCliente,IDEMPRESA,OBS";

// $filterColumnsArr = explode(",",$filterColumns);

// /* functions */
// function searchArr($dPost, $columnsDb) {
//     $pago = filter_input(INPUT_POST, "pago");
//     foreach($dPost as $key => $value) {
//         if(array_key_exists($key, $columnsDb) && $value != "") {
//             $value = $key === "pg" ? $pago : $value;
//             $searchArr[$columnsDb[$key]] = $value;
//         }
//     }
//     return $searchArr;
// }

// function where($searchArr, $statusOpt) {
//     $where = " AND ";
//     foreach($searchArr as $key => $value) {
//         if($value !== "") {
//             if($key === "DataCancelado") {
//                 $where .= $value == 1 ?
//                     " {$key} is null AND " : " {$key} is not null AND ";
//             } elseif($key === "DESATIVO") {
//                 $where .= " {$key} = 1 AND ";
//             } elseif($key === "dtInicio") {
//                 $where .= " DataVenda >= '{$value}' AND ";
//             } elseif($key === "dtFim") {
//                 $where .= " DataVenda <= '{$value}' AND ";
//             } else {
//                 $signal = preg_match('/^%|%$/', $value) ?
//                     "LIKE" : "=";
//                 $where .= " {$key} {$signal} '{$value}' AND ";
//             }
//         }
//     }

//     if(!array_key_exists("Status", $searchArr)) {
//         $where .= "(";
//         foreach($statusOpt as $opt) {
//             $where .= " Status = '" . $opt . "' OR";
//         }
//         /** Remove ultimo OR */
//         $where = substr($where, 0,strripos($where, "OR "));
//         $where .= ")";
//     } else {
//         $where = substr($where, 0,strripos($where, "AND"));
//     }

//     return $where;
// }

// function whereDataTable($requestData, $filterColumnsArr) {
//     $where = " AND ";
//     for($x = 0; $x < count($filterColumnsArr); $x++) {
//         $where .= " " . $filterColumnsArr[$x] . " LIKE '"
//             . $requestData['search']['value'] . "%' OR";
//     }
//     /** Remove ultimo OR */
//     $where = substr($where, 0,strripos($where, "OR"));

//     return $where;
// }

// function orderDataTable($requestData, $filterColumnsArr, $offset, int $rows) {
//     $pages = null;
//     /** sort results */
//     $numberColumn = $requestData['order'][0]['column'];
//     $numberColumn = $numberColumn < 1 ? 1 : $numberColumn - 1;
//     $order = " ORDER BY " . $filterColumnsArr[$numberColumn] . " " . $requestData['order'][0]['dir'] . " ";

//     $pages = " OFFSET {$offset} ROW FETCH NEXT {$rows} ROWS ONLY ";

//     return $order . $pages;
// }

// function getData($sql, $dadosVendedor) {
//     $datas = [];
//     $query = Connect::getInstance()->query($sql);
//     $dataDb = [];

//     /**
//      * open the file
//      */
//     $handle = fopen(__DIR__ . "/../web/percent.txt", "a");
//     $row = 1;

//     //$rowsTotal = getTotalRows($sql);

//     while($dVenda = $query->fetch()) {
//         foreach($dVenda as $method => $value) {
//             $d[$method] = formatColumn($method, $value, $dadosVendedor);
//         }
//         $d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
//         $d["Documentos"] = getImage($dVenda);
//         $d["Produto"] = getProduct($dVenda);
//         $datas[] = $d;

//         /**
//          * save the rows separeted by commas
//          */
//         fwrite($handle, "," . $row++);
//         //$percent = ($row * 100) / $rowsTotal;
//     }
//     fclose($handle);

//     return $datas;
// }

// function getImage($data) {
//     $imageId = "";
//     $cadArquivo = new Controller\CadArquivoController();
//     $search = new Dao\CriterioBusca();

//     $codDocumento = $data->Pedido;
//     $codEmpresa = $data->IDEMPRESA;
//     $search->setTabela("CadArquivos");
//     $search->setArray(array("COD_DOCUMENTO" => $codDocumento,
//         "COD_EMPRESA"=> $codEmpresa, "IND_LOCAL" => 5));

//     $listImg = $cadArquivo->listImage($search);

//     if(isset($listImg) && $listImg !== null) {
//         foreach($listImg as $v_) {
//             $class = "doc{$codDocumento}";
//             $doc = $v_;
//             $link = "<a id='{$doc}' style='text-decoration: none; cursor: pointer; color: blue' onclick='openDoc({$doc}, {$codDocumento})'><i class='fa fa-file'></i>{$doc}</a>";
//             $imageId .= $link . " ";
//         }
//     }

//     return isset($imageId) ? $imageId : null;
// }

// function getProduct($data, $columns = null): ?array {
//     $columns = [ "Item","IDProduto","Descrição","UniMedida","Quantidade","Valor" ];
//     $search = new Dao\CriterioBusca();
//     $product = new Controller\ProdutoVendaController();
//     $search->setArray(
//         array(
//             "Pedido" => $data->Pedido,
//             "IDEmpresa" => $data->IDEMPRESA
//         )
//     );
//     $search->setTop(0);
//     $productDb = $product->find($search)->getAll();
//     if(!empty($productDb)) {
//         foreach($productDb as $product) {
//             //$codeProduct = $product->getArray()["IDProduto"];
//             $item = $product->getArray()["Item"];
//             foreach($columns as $column) {
//                 $detProducts[$item][$column] = $product->getArray()[$column];
//             }
//         }
//     }

//     return isset($detProducts) ? $detProducts : null;
// }

// function getTotalRows($sql) {
//     $sql = str_replace("*","1",$sql);
//     $query = Connect::getInstance()->query($sql);
//     $query->fetchAll();
//     $tRows = $query->rowCount();

//     /** create the file or recreate with the total rows */
//     $handle = fopen(__DIR__ . "/../web/percent.txt", "w+");
//     fwrite($handle, $tRows);
//     fclose($handle);

//     return $tRows;
// }

// function formatColumn($method, $value, $dadosVendedor) {
//     if(!isset($situation)) {
//         $situation = new Situation();
//     }

//     if(!isset($Status)) {
//         $status = new Status();
//     }

//     switch($method) {
//         case "Pedido":
//             return "<span data-pedido='{$value}'>{$value}</span>";
//         case "IDEMPRESA":
//             return "<span data-idEmpresa='{$value}'>{$value}</span>";
//         case "Controle": case "NFNum":
//             return "<input type=text name='{$method}' value='{$value}' size=6 />";
//         case "DataVenda":
//             $date = new DateTime($value);
//             return $date->format("d/m/Y");
//         case "HoraVenda":
//             $date = new DateTime($value);
//             return $date->format("H:i");
//         case "VencOrcamento":
//             $date = new DateTime($value);
//             $value = $date->format("Y-m-d");
//             $validate = strtotime($value) - strtotime(date("Y-m-d"));
//             $dateExpired = $validate < 0 ? "style='color:red'" : null;
//             return "<input type=date name='{$method}' value='{$value}' size=6 {$dateExpired} />";
//         case "Vendedor":
//             $logOn = array_key_exists($value, $dadosVendedor) ?
//                 $dadosVendedor[$value]["LogON"] : "----";
//             return $logOn;
//         case "Situação":
//             $optionSituacao  = "<select name='Situação'>";
//             foreach($situation->getStage() as $stage) {
//                 $selected = ($value === $stage) ? "selected" : null;
//                 $optionSituacao .= "<option value='{$stage}' {$selected} >{$stage}</option>";
//             }
//             $optionSituacao .= "</select>";
//             return $optionSituacao;
//         case "DESATIVO":
//             $checked = $value == 1 ? "checked" : null;
//             return "<input type=checkbox name=DESATIVO {$checked}/>";
//         case "PAGO":
//             $checked = $value == 1 ? "checked" : null;
//             return "<input type=checkbox name=PAGO {$checked}/>";
//         case "Valor": case "TabComissao":
//         case "CreditoUtilizado": case "Frete":
//             return number_format($value, "2",",",".");
//         case "NUM_RASTREIOCORREIOS":
//             return "<input type=text name='{$method}' value='{$value}' size=10 />";
//         case "Status":
//             $optionStatus  = "<select name='Status'>";
//             foreach($status->getStatus() as $key => $sts) {
//                 $selected = $value === $key ? "selected" : null;
//                 $optionStatus .= "<option value='{$key}' {$selected} >{$sts}</option>";
//             }
//             $optionStatus .= "</select>";
//             return $optionStatus;
//         case "CustoVenda":
//             $value = number_format($value, "2",",",".");
//             return "<input type=text name=CustoVenda value='{$value}' size=8 style='color: red' />";
//         case "ORIGEM":
//             return $value === null ? "INTERNO" : "EXTERNO";
//         case "Itens":
//             return $value;
//         default:
//             return $value;
//     }
// }

// function getJson($requestData, $datas, $recordsTotal) {
//     if(isset($datas)) {
//         $rowCount = count($datas);
//     }
//     $jsonData = array(
//         "draw" => intVal($requestData["draw"]),
//         "recordsTotal" => intVal($rowCount),
//         "recordsFiltered" => intVal($recordsTotal),
//         "data" => $datas
//     );

//     return json_encode($jsonData);
// }
// /* FIM function */

// $searchArr = [];
// $datas = [];
// $where = "";

// $statusOpt = [ "V", "S", "O", "C", "CO" ];
// $paramsDataTable = [ "draw", "columns", "order", "start", "length", "search" ];

// $searchArr = searchArr($dPost, $columnsDb);

// $sql = "SELECT * FROM Venda where 1=1 ";
// $rowsTotal = "SELECT 1 FROM Venda where 1=1 ";
// //ORDER BY Pedido DESC OFFSET 0 ROW FETCH NEXT 2000 ROWS ONLY";

// if(!empty($searchArr)) {
//     $sql .= where($searchArr, $statusOpt);
//     $rowsTotal .= where($searchArr, $statusOpt);
// }

// if(!empty($requestData["search"]["value"])) {
//     $sql .= whereDataTable($requestData, $filterColumnsArr);
//     $rowsTotal .= whereDataTable($requestData, $filterColumnsArr);
// }

// $recordsTotal = getTotalRows($rowsTotal);

// $sql .= orderDataTable($requestData, $filterColumnsArr, intVal($requestData['start']), intVal($requestData['length']));

// /* Dados do Vendedor */
// $dadosVendedor = [];
// $query = Connect::getInstance()->query("SELECT * FROM Vendedor WHERE 1=1");              ;
// foreach($query->fetchAll(PDO::FETCH_CLASS, \Model\VendedorModel::class) as $dVendedor) {
//     foreach($dVendedor as $method => $value) {
//         $d[$method] = $value;
//     }
//     $dadosVendedor[$dVendedor->ID_Vendedor] = $d;
// }

// $datas = getData($sql, $dadosVendedor);

// return print(getJson($requestData, $datas, $recordsTotal));
