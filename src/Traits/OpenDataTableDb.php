<?php

namespace Traits;

Trait OpenDataTableDb
{
    public static $entity;

    public function searchArr($data, $entity): array
    {
        $searchArr = [];
        $columnsDb = $this->getColumnsDb($data, $entity);
        foreach($data as $key => $value) {
            //if(array_key_exists($value["name"], $columnsDb) && $value["value"] != "") {
            if(is_numeric($key) && array_key_exists($value["name"], $columnsDb)) {
                $searchArr[$columnsDb[$value["name"]]] = $value["value"];
            }
        }
        return $searchArr;
    }

    private function validate($searchArr): ?string
    {
        $where = "";
        foreach($searchArr as $key => $value) {
            if($value !== "") {
                $signal = preg_match('/^%|%$/', $value) ? "LIKE" : "=";
                $where .= " AND {$key} {$signal} '{$value}' ";
            }
        }
        return $where;
    }

    public function orderDataTable($data, $offset, int $rows): ?string
    {
        $pages = null;
        $order = " ORDER BY " . $this->getFilterColumns($data) . " " . $data['order'][0]['dir'] . " ";
        $pages = " OFFSET {$offset} ROW FETCH NEXT {$rows} ROWS ONLY ";

        return $order . $pages;
    }

    public function getFilterColumns($data): string
    {
        return $this->changeColumn($data["columns"][$data["order"][0]["column"]]["data"]);
    }

    // private $requestData;

    // public function __construct(array $data) {
    //     $this->requestData = $data;
    //     var_dump($this->requestData);
    // }

    // public function init(array $data)
    // {
    //     $this->requestData = $data;
    //     $searchArr = [];
    //     $where = "";

    //     $statusOpt = [ "V", "S", "O", "C", "CO" ];
    //     $paramsDataTable = [ "draw", "columns", "order", "start", "length", "search" ];

    //     $searchArr = $this->searchArr($data);
    //     $sql = (empty($data["status"]) ? "SELECT * FROM Venda where  Status!='C' AND Status!='CO' " : "SELECT * FROM Venda where  1=1 ");

    //     if(!empty($searchArr)) {
    //         $sql .= $this->validate($searchArr);
    //     }

    //     if(!empty($data["search"]["value"])) {
    //         $sql .= $this->whereDataTable($data);
    //     }

    //     $recordsTotal = $this->getTotalRows($sql);

    //     if(!empty($data["order"])) {
    //         $sql .= $this->orderDataTable($data, intVal($data['start']), intVal($data['length']));
    //     }

    //     /* Seller's Data */
    //     $salemanDb = new \Models\Saleman();
    //     foreach($salemanDb->activeAll() as $saleman) {
    //         $dataSaleman[$saleman->ID_Vendedor] = [
    //             "LogON" => $saleman->LogON,
    //             "Nome" => $saleman->Nome,
    //             "IDEmpresa" => $saleman->IDEmpresa
    //         ];
    //     }

    //     $datas = $this->getData($sql, $searchArr, $data["columns"]);
    //     return print($this->getJson($datas, $recordsTotal));
    // }

    // public function getTotalRows($sql): int
    // {
    //     $sale = new \Models\Sale();
    //     $sql = str_replace("*","1",$sql);
    //     $tRows = count($sale->readDataTable($sql)->fetchAll());

    //     /** create the file or recreate with the total rows */
    //     $logon = $_SESSION["login"]->Logon;
    //     $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "w+");
    //     fwrite($handle, $tRows);
    //     fclose($handle);

    //     return $this->tRows = $tRows;
    // }

    // public function getData(string $sql, array $searchArr, array $columns=null): array
    // {
    //     $sale = new \Models\Sale();
    //     $dataDb = $sale->readDataTable($sql, $searchArr);
    //     $datas = [];
    //     $exceptions = [ "Arquivos","Documentos","Produto" ];
    //     foreach($columns as $column) {
    //         if(!empty($column["data"]) && !in_array($column["data"], $exceptions)) {
    //             $columnNames[] = $column["data"];
    //         }
    //     }

    //     /** open the file */
    //     $logon = $_SESSION["login"]->Logon;
    //     $handle = fopen(__DIR__ . "/../public/percent_{$logon}.txt", "a");
    //     $row = 0;

    //     //$rowsTotal = getTotalRows($sql);

    //     //while($dVenda = $query->fetch()) {
    //     if(!empty($dataDb)) {
    //         foreach($dataDb as $dVenda) {
    //             foreach($columnNames as $columnName) {
    //                 $d[$columnName] = $this->formatColumn($columnName, $dVenda->$columnName);
    //             }
    //             //$d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
    //             $d["Arquivos"] = "<input type='file' name='anexo-" . $dVenda->Pedido . "[]' multiple />";
    //             $d["Documentos"] = $this->getImage($dVenda);
    //             $d["Produto"] = $this->getProduct($dVenda);
    //             $datas[] = $d;

    //             /** save the rows separeted by commas */
    //             fwrite($handle, "," . $row++);
    //             $percent = ($row * 100) / $this->tRows;
    //             setcookie("row", $row, time() + (86400 * 30), "/");
    //         }
    //     }
    //     fclose($handle);
    //     return $datas;
    // }
}
