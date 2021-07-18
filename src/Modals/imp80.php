<?php //require __DIR__ . "/../includes/imp.php"; ?>

<script>
    $(document).ready(function(){
        $(document).on("keyup", function(e) {
            e.preventDefault();
            if(e.keyCode === 27) {
                $("#imp80, #mask_main").hide();
            }
        });
        $(".close-modal").on("click", function() {
            $("#imp80, #mask_main").hide();
        });
        $(".muda").click(function(){
            $("#imp80, #mask_main").hide();
            $(".loading, #mask_main").show();
            $("#imp40").load("print/40", {companyId: companyId, salesOrder: salesOrder}, function() {
                $('#imp40').show();
            });
        });
        // if(typeof(pedido) !== "undefined")
        // {
        //     $(".muda").click(function(){
        //         $("#lendo, .mask").show();
        //         $("#imp40").load("../paginas/imp40.php?IDEmpresa="
        //             + IDEmpresa + "&pedido=" + pedido
        //                 + "&origem=gerOrc&cnpjCpf=" + cnpjCpf );
        //         $('#imp40').appendTo('body').modal();
        //     });
        // }
        $(".loading").hide();
    });
</script>
<style>

    #imp80 {
        //min-width: 1000px;
        margin: 0 auto;
        padding: 0px;
        font-family: "Arial";/*"Courier New";*/
        //font-size: 28px !important;
        font-weight: 900;
        //text-transform: uppercase;
        background: white;
        overflow: auto;
    }

    /* .imp80 {
        font-size: 1.3em;
    } */

    .btn-print {
        width: 100%;
        font-size: 1.2em;
        text-transform: uppercase;
    }

    /* .modal .close-modal {
        top: 16px;
        font-size: 1.4em;
    } */

    /* #imp80 hr {
        border-top: 4px dashed #000;
        margin: 0;
    } */
</style>
<div class='noprintable botoesImp'>
    <button class="btn-dark btn-print" onclick="window.print()">Imprimir</button>
    <!-- <a href="#close-modal" rel="modal:close" class="close-modal ">Close</a> -->
    <i class="fa fa-times close-modal" style="top: 16px; font-size: 1.4em" rel="modal:close" aria-hidden="true" title="Fechar"></i>
    <?php //if( !isset($dados->Pedido) ): ?>
        <button class='btn-danger col80 muda btn-print'>Mudar para Cupom(Menor)
        </button>
    <?php //endif; ?>
</div>

<div class="imp80" style="display: block" class="pr-4">
    <div class="mr-3 ml-3">
        <div class="row mt-3">
            <div class="col">
                <div style="font-weight: 900">
                    <h5><?= ($company->NomeFantasia ?? null) ?>
                    </h5>
                </div>
                <div>
                    <?= ($company->CNPJ ?? null) ?>
                    <?= ($company->InscEstadual ?? null) ?>
                </div>
                <div>
                    <?= ($company->Rua ?? null) . ", " . ($company->Num ?? null) . " (" . ($company->Complemento ?? null) . ") " . ($company->Bairro ?? null) ?>
                </div>
                <div>
                    <?= "CEP: " . ($company->Cep ?? null) ?><?= " - " . ($company->Cidade ?? null) . " / " . ($company->UF ?? null) ?>
                </div>
                <div>
                    Tel: <?= ($company->Telefone ?? null) ?>
                    Fax: <?= ($company->Fax ?? null) ?>
                </div>
            </div>
            <div class="col-3" align="right">
                <div>
                    <img src="themes/template1/assets/img/logo.png" alt="logo" height="90" />
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col"></div>
            <div class="mt-1 col-3" >
                <div align="center" style="font-weight: 900">
                    <h4><?= (isset($pedido) && $pedido->Status === "V" ? "PEDIDO DE VENDA" : "ORÇAMENTO") ?></h4>
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col"></div>
            <div class="col-3" style="font-weight: 900" align="right">
                Nº Controle: <?= ($pedido->Controle ?? null) ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
                Vendedor......: <?= ($saleman ?? null) ?>
            </div>
            <div class="col" >
                Data Registro: <?= ($dataHoraVenda ?? null) ?>
            </div>
            <div class="col-2" align="center" >
                <h5>Nº <span style="color: red"><?= ($pedido->Pedido ?? null) ?></span></h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Cliente..........: <?= ($pedido->NomeCliente ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                N. Fantasia...: <?= ($client->NomeFantasia ?? null) ?>
            </div>
            <div class="col-4">
                Comprador: <?= ($pedido->Comprador ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                Endereço......: <?= ($client->Rua ?? null) . ", " . ($client->Num ?? null) . "(" . ($client->Complemento ?? null) . ")" ?>
            </div>
            <div class="col-4">
                Fone..........: <?= ($client->TelResid ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                Bairro............: <?= ($client->Bairro ?? null) ?>
            </div>
            <div class="col">
                CEP.: <?= ($client->CEP ?? null) ?>
            </div>
            <div class="col-4">FAX............: <?= ($client->FAX ?? null) ?></div>
        </div>
        <div class="row">
            <div class="col-5">
                Cidade..........: <?= ($client->Cidade ?? null) ?></div>
            <div class="col">
                UF....: <?= ($client->UF ?? null) ?></div>
            <div class="col-4">
                Tel2............: <?= ($client->Tel02 ?? $client->Celular ?? null) ?></div>
        </div>
        <div class="row">
            <div class="col-5">
                CNPJ/CPF.....: <?= ($pedido->CNPJeCPF ?? null) ?>
            </div>
            <div class="col">
                IE.....: <?= ($client->InsEstadual ?? null) ?>
            </div>
            <div class="col-3">Nº Tab Venda: </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col">
                <table class="table-sm" border="1" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">ÍTEM</th>
                            <th style="text-align:center">CÓDIGO</th>
                            <th style="text-align:center">
                                DESCRIÇÃO DO PRODUTO</th>
                            <th style="text-align:center">UND</th>
                            <th style="text-align:center">NCM</th>
                            <th style="text-align:center">QTD</th>
                            <th style="text-align:center">VALOR UNI</th>
                            <th style="text-align:center">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 0;
                        $tItens = 0;
                        $tProd = 0;
                        if (!empty($products)):
                            foreach ($products as $product):
                                ?>
                                <tr>
                                    <td align="center">
                                        <?= ++$cont ?></td>
                                    <td align="center">
                                        <?= $product->IDProduto ?></td>
                                    <td>
                                        <?= $product->Descrição ?></td>
                                    <td align="center">
                                        <?= $product->UniMedida ?></td>
                                    <td></td>
                                    <td align="center">
                                        <?= (int) $product->Quantidade ?>
                                    </td>
                                    <td align="right">
                                        <?= number_format($product->Valor, 2, ',', '.') ?></td>
                                    <td align="right">
                                        <?= number_format($product->Valor * $product->Quantidade, 2, ',', '.') ?></td>
                                </tr>
                                <?php
                                    $tItens += $product->Quantidade;
                                    $tProd += $product->Valor * $product->Quantidade;
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">Total Itens...: <?= ($tItens ?? null) ?></div>
            <div class="col">Peso Bruto: <?= ($grossWeight ?? null) ?> Kg</div>
            <div class="col-3">Total Produtos..:</div>
            <div class="col-2" align="right">
                <?= (number_format($tProd, 2, ',', '.') ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Transportadora: <?= ($transport ?? null) ?>
            </div>
            <div class="col">Data Entrega: <?= ($dataEntrega ?? null) ?></div>
            <div class="col-3">Outros(+)...........: </div>
            <div class="col-2" align="right">0,00</div>
        </div>
        <div class="row">
            <div class="col">
                <?= ($produto->TipoEntrega ?? null) ?>
            </div>
            <div class="col-3">Frete (+).............: </div>
            <div class="col-2" align="right">
                <?= (number_format($pedido->Frete, 2, ',', '.') ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-3">Desconto (-).......: </div>
            <div class="col-2" align="right">
                <?= (number_format($pedido->Desconto, 2, ',', '.') ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-3">Total (=)..............: </div>
            <div class="col-2" align="right">
                R$ <?= (number_format($tProd + $pedido->Frete - $pedido->Desconto, 2, ',', '.') ?? null) ?>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-2" align="right">OBS: </div>
            <div class="col" align="left">
                <?= ($pedido->OBS ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-2">End. Entrega: </div>
            <div class="col" align="left">O MESMO INFORMADO ACIMA</div>
        </div>
        <div class="row">
            <div class="col-2">End. Cobrança: </div>
            <div class="col" align="left">O MESMO INFORMADO ACIMA</div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                Forma Pagamento:
                <span class="ml-2"><?= ($formPayment ?? null) ?></span>
            </div>
            <div class="col">
                <table class="table-sm" border="1" width="100%"">
                    <thead>
                        <tr>
                            <th style="text-align: center">Vencimento</th>
                            <th style="text-align: center">Valor</th>
                            <th style="text-align: center">Nº Doc.</th>
                            <th style="text-align: center">Tipo Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(!empty($salePayments)):
                            foreach($salePayments as $salePayment): ?>
                            <tr>
                                <td align="center"><?= date("d/m/Y",
                                    strtotime($salePayment->Vencimento)) ?>
                                </td>
                                <td align="right"><?= number_format($salePayment
                                    ->Valor,"2",",",".") ?></td>
                                <td align="center">
                                    <?= $salePayment->NumDoc ?>
                                </td>
                                <td align="center">
                                    <?= $salePayment->TipoPag ?>
                                </td>
                            </tr>
                    <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-2">Qtd. Vol: _______</div>
            <div class="col">Separado Por: _____________________</div>
            <div class="col">Conferido Por: _____________________</div>
            <div class="col-2"><input type="checkbox" /> Cobrança</div>
        </div>
        <div class="row mt-3">
            <div class="col">Nome: __________________________________</div>
            <div class="col">Assinatura: ________________________</div>
            <div class="col-2"><input type="checkbox" /> Cliente</div>
        </div>
        <div class="row mt-3">
            <div class="col">Nº Nota Fiscal: ___________</div>
            <div class="col">Data: ____/____/_________</div>
            <div class="col-2"><input type="checkbox" /> Controle</div>
        </div>
    </div><!-- mr-3 ml-3 -->
</div><!-- IMP80 -->
