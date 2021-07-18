<?php //require __DIR__ . "/../includes/imp.php"; ?>

<script>
    $(document).ready(function(){
        $(document).on("keyup", function(e) {
            e.preventDefault();
            if(e.keyCode === 27) {
                $("#imp40, #mask_main").hide();
            }
        });
        $(".close-modal").on("click", function() {
            $("#imp40, #mask_main").hide();
        });
        $(".muda").click(function(){
            $("#imp40, #mask_main").hide();
            $(".loading, #mask_main").show();
            $("#imp80").load("print/80", {companyId: companyId, salesOrder: salesOrder}, function() {
                $('#imp80').show();
            });
        });

        // var qrcode = new QRCode(document.getElementById("qrcode"), {
        //     width : 300,
        //     height : 300
        // });

        // function makeCode () {
        //     var elText = "http://www.lojascom.com.br";
        //     if (!elText) {
        //         return;
        //     }
        //     qrcode.makeCode(elText);
        // }
        // makeCode();

        /* ocultar espera */
        $(".loading").hide();
    });
</script>

<style>
    #imp40 {
        min-width: 1000px;
        margin: 0 auto;
        padding: 0px;
        font-family: "Arial";/*"Courier New";*/
        font-size: 28px !important;
        font-weight: 900;
        text-transform: uppercase;
        background: white;
        overflow: auto;
    }

    /* .imp40 {
    } */

    #imp40 hr {
        border-top: 4px dashed #000;
        margin: 0;
    }

    /* estilização da janela */
    .modal {
        max-width: 30cm;
    }

    .modal .close-modal {
        top: 39px;
        right: 20px;
        position: absolute;
        display: block;
        width: 30px;
        height: 30px;
        text-shadow: -1px -3px 3px white;
        /* text-indent: -9999px; */
        /* background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAAXNSR0IArs4c6QAAA3hJREFUaAXlm8+K00Acx7MiCIJH/yw+gA9g25O49SL4AO3Bp1jw5NvktC+wF88qevK4BU97EmzxUBCEolK/n5gp3W6TTJPfpNPNF37MNsl85/vN/DaTmU6PknC4K+pniqeKJ3k8UnkvDxXJzzy+q/yaxxeVHxW/FNHjgRSeKt4rFoplzaAuHHDBGR2eS9G54reirsmienDCTRt7xwsp+KAoEmt9nLaGitZxrBbPFNaGfPloGw2t4JVamSt8xYW6Dg1oCYo3Yv+rCGViV160oMkcd8SYKnYV1Nb1aEOjCe6L5ZOiLfF120EjWhuBu3YIZt1NQmujnk5F4MgOpURzLfAwOBSTmzp3fpDxuI/pabxpqOoz2r2HLAb0GMbZKlNV5/Hg9XJypguryA7lPF5KMdTZQzHjqxNPhWhzIuAruOl1eNqKEx1tSh5rfbxdw7mOxCq4qS68ZTjKS1YVvilu559vWvFHhh4rZrdyZ69Vmpgdj8fJbDZLJpNJ0uv1cnr/gjrUhQMuI+ANjyuwftQ0bbL6Erp0mM/ny8Fg4M3LtdRxgMtKl3jwmIHVxYXChFy94/Rmpa/pTbNUhstKV+4Rr8lLQ9KlUvJKLyG8yvQ2s9SBy1Jb7jV5a0yapfF6apaZLjLLcWtd4sNrmJUMHyM+1xibTjH82Zh01TNlhsrOhdKTe00uAzZQmN6+KW+sDa/JD2PSVQ873m29yf+1Q9VDzfEYlHi1G5LKBBWZbtEsHbFwb1oYDwr1ZiF/2bnCSg1OBE/pfr9/bWx26UxJL3ONPISOLKUvQza0LZUxSKyjpdTGa/vDEr25rddbMM0Q3O6Lx3rqFvU+x6UrRKQY7tyrZecmD9FODy8uLizTmilwNj0kraNcAJhOp5aGVwsAGD5VmJBrWWbJSgWT9zrzWepQF47RaGSiKfeGx6Szi3gzmX/HHbihwBser4B9UJYpFBNX4R6vTn3VQnez0SymnrHQMsRYGTr1dSk34ljRqS/EMd2pLQ8YBp3a1PLfcqCpo8gtHkZFHKkTX6fs3MY0blKnth66rKCnU0VRGu37ONrQaA4eZDFtWAu2fXj9zjFkxTBOo8F7t926gTp/83Kyzzcy2kZD6xiqxTYnHLRFm3vHiRSwNSjkz3hoIzo8lCKWUlg/YtGs7tObunDAZfpDLbfEI15zsEIY3U/x/gHHc/G1zltnAgAAAABJRU5ErkJggg==') */
    }

    .btn-print {
        width: 100%;
        font-size: 1.2em;
        text-transform: uppercase;
    }

</style>

<div class='noprintable botoesImp'>
    <button class="btn-print btn-dark" onclick="window.print()">Imprimir</button>
    <!-- <a href="#close-modal" rel="modal:close" class="close-modal ">Close</a> -->
    <i class="fa fa-times close-modal" rel="modal:close" aria-hidden="true" title="Fechar"></i>
    <!-- <button class='btn-sm btn-danger col80 muda'>Mudar para A4(Grande)</button> -->
    <button class='btn-print btn-danger col80 muda'>Mudar para A4(Grande)</button>
</div>
<div align="center" class="m-2"><?= ($company->NomeFantasia ?? null) ?>
    <div class="row">
        <div class="col-6"  style="text-align: left">
            Tel: <?= ($company->Telefone ?? null) ?></div>
        <div class="col-6"  style="text-align: right">
            Fax: <?= ($company->Fax ?? null) ?></div>
    </div>
    <div style="float: right;">
        DATA REGISTRO: <?= ($dataHoraVenda ?? null) ?>
    </div>
    <br><hr>
    <div class="row">
        <div class="col" align="center">Deus seja louvado!</div>
    </div>
    <div class="row">
        <div class="col"  align="left">Vendedor: <?= ($saleman ?? null) ?></div>
        <div align="right" class="col" >PEDIDO: <?= ($pedido->Pedido ?? null) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-2" align="right">Cliente..:</div>
        <div class="col" align="left">
            <span class='ml-3 mr-3'><?= ($pedido->NomeCliente ?? null) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-2" align="right">End..........: </div>
        <div class="col" align='left'>
            &nbsp&nbsp<?= ($client->Rua ?? null) . ", " . ($client->Num ?? null) . " (" . ($client->Complemento ?? null) . ")" ?>
        </div>
    </div>
    <div class="row">
        <div class="col-2" align='left'></div>
        <div class="col ml-3" align="left">
            <?= ($client->Bairro ?? null) . " - " . ($client->Cidade ?? null) . " / " . ($client->UF ?? null) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-2" style="text-align: left">CNPJ/CPF:</div>
        <div class="col ml-1" style="text-align: left">
            <span class='ml-3 mr-3'>
                <?= ($pedido->CNPJeCPF ?? null) ?>
            </span>
        </div>
    </div>
    <!--<div>-->
    <table width="100%" border="3" id="cupom" >
        <thead>
            <tr>
                <th rowspan="2" width="40px" style="text-align:center">Ítem</th>
                <th rowspan="2" width="60px" style="text-align:center">Cód</th>
                <th rowspan="2" width="600px" >Descrição</th>
                <th width="30px" style="text-align:center">Uni</th>
                <th width="30px" style="text-align:center">Qtd</th>
                <th style="text-align:right;padding-right: 7px;">Valor</th>
            </tr>
            <tr>
                <th colspan="3" style="text-align:right">Total Ítem</th>
            <tr>
        </thead>
        <tbody>
            <?php
            $totalProd = 0;
            if(!empty($products)):
                foreach ( $products as $product ):
                    ?>
                    <tr>
                        <td rowspan="2" align="center">
                            <?= ($product->Item ?? null) ?></td>
                        <td rowspan="2" align="center">
                            <?= ($product->IDProduto ?? null) ?></td>
                        <td rowspan="2">
                            <?= ($product->Descrição ?? null) ?></td>
                        <td align="center">
                            <?= ($product->UniMedida ?? null) ?></td>
                        <td align="center">
                            <?= ((int)$product->Quantidade ?? null) ?></td>
                        <td align="right" style='padding-right: 7px'>
                            <?php (number_format($product->Valor, 2, ",", ".") ?? null) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right" style='padding-right: 7px'>
                            <?= number_format($totalItem = $product->Quantidade * $product->Valor, 2, ',', '.') ?></td>
                    </tr>
                    <?php
                    $totalProd += $totalItem;
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-7" align="left">
            Forma de Pag.: &nbsp<?= ($formPay ?? null) ?></div>
        <div class="col-2" align='right'>
            Subt.......:</div>
        <div class="col" align="right">
            <?= (!empty($totalProd) ? number_format($totalProd, 2, ',', '.') : null) ?>
        </div>
    </div>
    <div class="row">
        <div class="col" align="left">
            Transport.......: <?= ($transport ?? null) ?>
        </div>
        <div class="col-2" align='right'>
            Frete(+):
        </div>
        <div class="col-3" align="right">
            <?= number_format($pedido->Frete, 2, ",", ".") ?>
        </div>
    </div>
    <div class="row">
        <div class="col" align="left">
            Entrega...........: &nbsp<?= ($dataEntrega ?? null) ?>
        </div>
        <div class="col-2" align='right'>Desc(-) ..:</div>
        <div class="col-3" align="right">
            <?= (!empty($pedido->Desconto) ? number_format($pedido->Desconto, 2, ",", ".") : null) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-7" align="left"><?= $tipoEnt ?? null ?></div>
        <div class="col-2" align='right'>Total(=):</div>
        <div class="col-3" align="right">
            <?= (!empty($totalProd) ? number_format($totalProd + $pedido->Frete - $pedido->Desconto, 2, ',', '.') : null) ?></div>
    </div><br>
    <div class="row">
        <div class="col-1" align="left">OBS:</div>
        <div class="col-11" align="left">&nbsp<?= ($pedido->OBS ?? null) ?></div>
    </div>
    <div class="row">
        <div class="col">
            <div id="qrcode" class="mt-2"></div>
            <!-- <img src="../web/img/LojasCom.png" alt="qr" /> -->
        </div>
    </div>
    <br>
    <div align="left">
        Assinatura:<hr style="margin: -15px 0 0 298px; border: 3px solid">
    </div><br>
</div><!-- class imp40 -->
