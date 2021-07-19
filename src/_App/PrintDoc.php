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
        $date = explode("-",explode(" ",$pedido->DataVenda)[0]);
        $hour = substr(explode(" ",$pedido->HoraVenda)[1], 0,5);
        $dataHoraVenda = "{$date[2]}/{$date[1]}/{$date[0]} {$hour}";
        $date = explode("-", explode(" ", $pedido->DataEntrega)[0]);
        $hour = substr(explode(" ",$pedido->HoraEntrega)[1], 0,5);
        $dataEntrega = "{$date[2]}/{$date[1]}/{$date[0]} {$hour}";

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

        /** Form payment */
        $formPayment = ((new \Models\FormPayment())->load($pedido->FormaPagamento)->Descrição ?? null);

        $this->view->setPath("Modals")->render("imp40", [ compact("pedido","dataHoraVenda","client","dataEntrega","saleman","transport","products","formPayment","company") ]);
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
        $date = explode("-",explode(" ",$pedido->DataVenda)[0]);
        $hour = substr(explode(" ",$pedido->HoraVenda)[1], 0,5);
        $dataHoraVenda = "{$date[2]}/{$date[1]}/{$date[0]} {$hour}";
        $date = explode("-", explode(" ", $pedido->DataEntrega)[0]);
        $hour = substr(explode(" ",$pedido->HoraEntrega)[1], 0,5);
        $dataEntrega = "{$date[2]}/{$date[1]}/{$date[0]} {$hour}";

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
            $grossWeight += ($stock->load($product->IDProduto)->PESOBRUTO ?? 0);
        }

        /** Form payment */
        $formPayment = ((new \Models\FormPayment())->load($pedido->FormaPagamento)->Descrição ?? null);
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
