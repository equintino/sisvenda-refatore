<?php

namespace _App;

class PrintDoc extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init40($data): void
    {
        $companyId = $data["companyId"];
        $salesOrder = $data["salesOrder"];
        echo "<script>var companyId={$companyId}; var salesOrder={$salesOrder}</script>";

        /** Client salesOrder */
        $where = [
            "IDEmpresa" => $companyId,
            "Pedido" => $salesOrder
        ];
        $pedido = (new \Models\Sale())->search($where)[0];
        $date = (!empty($pedido->DataEntrega) ? explode("-", explode(" ", $pedido->DataEntrega)[0]) : null);
        $dataEntrega = (!empty($date) ? "{$date[2]}/{$date[1]}/{$date[0]}" : null);
        $date = (!empty($pedido->DataVenda) ? explode("-",explode(" ",$pedido->DataVenda)[0]) : null);
        $dataHoraVenda = (!empty($date) ? "{$date[2]}/{$date[1]}/{$date[0]}" . explode(" ",$pedido->HoraVenda)[1] : null);

        /** Company data */
        $company = (new \Models\Company())->load($companyId);

        /** Client data */
        $client = (new \Models\Client())->load($pedido->IDCliente);

        /** Saleman data */
        $saleman = (new \Models\Saleman())->load($pedido->Vendedor)->LogON;

        /** Transport data */
        $transport = (new \Models\Transport())->load($pedido->Transportadora)->RasSocial;

        /** Product data */
        $products = (new \Models\Product())->search($where);

        /** Pay form */
        $formPay = $pedido->FormaPagamento;

        $this->view->setPath("Modals")->render("imp40", [ compact("pedido","dataHoraVenda","client","dataEntrega","saleman","transport","products","formPay","company") ]);
    }

    public function init80($data): void
    {
        $companyId = $data["companyId"];
        $salesOrder = $data["salesOrder"];
        echo "<script>var companyId={$companyId}; var salesOrder={$salesOrder}</script>";

        /** Client salesOrder */
        $where = [
            "IDEmpresa" => $companyId,
            "Pedido" => $salesOrder
        ];
        $pedido = (new \Models\Sale())->search($where)[0];
        $date = explode("-", explode(" ", $pedido->DataEntrega)[0]);
        $dataEntrega = "{$date[2]}/{$date[1]}/{$date[0]}";
        $date = explode("-",explode(" ",$pedido->DataVenda)[0]);
        $dataHoraVenda = $date[2] . "/" . $date[1] . "/" . $date[0] . " " . explode(" ",$pedido->HoraVenda)[1];

        /** Company data */
        $company = (new \Models\Company())->load($companyId);

        /** Client data */
        $client = (new \Models\Client())->load($pedido->IDCliente);

        /** Saleman data */
        $saleman = (new \Models\Saleman())->load($pedido->Vendedor)->LogON;

        /** Transport data */
        $transport = (new \Models\Transport())->load($pedido->Transportadora)->RasSocial;

        /** Product data */
        $products = (new \Models\Product())->search($where);

        /** Details Stock */
        $stock = new \Models\Stock();
        $grossWeight = 0;
        foreach($products as $product) {
            $grossWeight += $stock->load($product->IDProduto)->PESOBRUTO;
        }

        /** Form payment */
        $formPayment = (new \Models\FormPayment())->load($pedido->FormaPagamento)->Descrição;
        $where = [
            "PEDIDO" => $salesOrder,
            "IDEmpresa" => $companyId
        ];
        $salePayments = (new \Models\SalePayment())->search($where);

        $this->view->setPath("Modals")->render("imp80", [ compact("pedido","dataHoraVenda","client","dataEntrega","saleman","transport","products","company","grossWeight","formPayment","salePayments") ]);
    }

    // public function loadImage($data): void
    // {
    //     $fileRegistration = new \Models\FileRegistration();
    //     if( isset( $data["id"] ) ) {
    //         $document = $fileRegistration->showImage($data["id"]);
    //         if(!$document) {
    //             echo "<div style='color: red'><blink>Desculpe! Parece que o anexo foi excluído.</blink></div>";
    //         }
    //         echo $document;
    //     } else {
    //         echo "Nenhum arquivo encontrado!";
    //     }
    // }

    // public function delete(array $data)
    // {
    //     $fileRegistration = new \Models\FileRegistration();
    //     $file = $fileRegistration->load($data["id"]);
    //     $file->destroy();
    //     return print(json_encode($file->message()));
    // }

}
