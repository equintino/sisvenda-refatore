<?php

namespace _App;

class Product extends Controller
{
    public function list(array $data)
    {
        var_dump($data);die;
    }

    public function load(array $data)
    {
        $product = new \Models\Product();
        $saleOrder = $this->cleanData($data, "Pedido");
        $company = $this->cleanData($data, "IDEMPRESA");
        $productDb = $product->search(["Pedido" => $saleOrder, "IDEmpresa" => $company]);

        foreach($productDb as $prod) {
            $list[] = [
                "Item" => $prod->Item,
                "IDProduto" => $prod->IDProduto,
                "Descrição" => $prod->Descrição,
                "UniMedida" => $prod->UniMedida,
                "Quantidade" => $prod->Quantidade,
                "Valor" => $prod->Valor
            ];
        }
        return print(json_encode($list));
    }

    private function cleanData(array $data, string $extract)
    {
        $a = substr($data[$extract],strpos($data[$extract],">"));
        return  substr($a,1,strpos($a,"<")-1);
    }
}
