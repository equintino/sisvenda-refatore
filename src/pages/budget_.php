<!-- <link rel="stylesheet" href="../assets/styleOrcamento.css" > -->

<?php //require __DIR__ . "/../includes/orcamento.php"; ?>

<style>
    .container-fluid {
        max-width: 1420px;
    }

    #top {
        display: none;
    }

    #filtroOrc {
        background: green;
        color: white;
        font-size: 11px;
        text-transform: uppercase;
    }

    #filtroOrc td {
        height: 35px;
    }

    #tabFiltroOrc {
        display: flex;
        justify-content: center;
    }

    #dClient input, #dEntrega input {
        margin: 2px;
    }

    /* Desktop */
    @media (min-width: 978px) {

        #acBusca {
            top: 4px;
            left: 23px;
        }

        #acBusca input {
            margin-top: 5px;
        }

        #acBusca span {
            margin-top: -4px;
        }

        #acBtn {
            float: right;
            position: relative;
            top: 5px;
            padding-bottom: 10px;
        }

        #info #dClient {
            margin-left: 20px;
            border-right: 1px solid gray;
        }

        #ltProd {
            margin-left: 20px;
        }
    }

    /* tablet */
    @media (min-width: 360px) and (max-width: 960px) {
        .atalho {
            display: none;
        }

        #info #dClient, #info #dEntrega {
            margin-top: 10px;
        }

        #detPedido {
            margin-top: 10px;
        }
    }

    /* mobile */
    @media (max-width: 360px) {
        .atalho {
            display: none;
        }

        #info {
            margin-right: 0px;
        }

        #info #dClient, #info #dEntrega {
            margin-top: 10px;
        }

        #detPedido {
            margin-top: 10px;
        }

        #posResumo {
            position: relative;
            top: 230px;
        }

        #posResumo #doc {
            margin-left: 50px;
        }
    }

    #tPagina {
        color: white;
    }

    .atalho {
        font-size: 11px;
        font-weight: 700;
        color: #176413;
    }

    #acBusca {
        clear: both;
        float: left;
    }

    #acBusca input {
        font-size: 13px;
    }

    #acBusca span {
        height: 20px;
    }

    .dados {
        margin-top: 5px;
    }

    #acoes input {
        height: 26px;
    }

    #busca {
        border-radius: 5px 0 0 5px;
    }

    #acoes span.busca {
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .cSearch, .nCBusca {
        cursor: pointer;
    }

    #ltProd .titulo {
        margin-left: 0;
        padding: 8px 0;
    }

    #ltProd #add, #acoes #acBusca i, .titulo {
        font-size: 14px;
    }

    .titulo .cSearch {
        padding: 0 5px;
        font-size: 10px;
    }

    #info, #info input {
        font-size: 13px;
    }

    #info input {
        border-radius: 5px;
        height: 20px;
        text-align: center;
    }

    #info {
        margin-left: 0;
    }

    #info #dClient, #info #dEntrega {
        background: #F5ECCE;
        min-height: 150px;
        padding-top: 8px;
        box-shadow: 1px 1px 2px gray;
    }

    #tabPag thead {
        font-size: 9px;
    }

    #tabProd {
        font-size: 11px;
        border: 1px solid gray;
    }

    #tabPag {
        max-height: 83px;
    }

    #tabProd tr {
        text-align: center;
    }

    #tabProd .remove {
        cursor: pointer;
    }

    #resumo .totais {
        font-size: 11px;
        font-weight: bolder;
    }

    #resumo {
        font-size: .8em;
    }

    #formaPagamento, #obs {
        font-size: 11px;
    }

    #formaPagamento {
        float: left;
        margin-right: 10px;
    }

    fieldset {
        border: 1px solid gray;
        padding: 0 10px;
        margin: -20px 0 20px 0;
    }

    .rotation {
        margin-left: -25px;
        margin-top: 29px;
        -ms-transform: rotate(-90deg); /* IE 9 */
        -webkit-transform: rotate(-90deg); /* Chrome, Safari, Opera */
        transform: rotate(-90deg);
    }

    /* janela ajax */
    #ajax {
        padding: 20px;
        position: relative;
        margin: -480px auto;
        max-width: 800px;
        max-height: 400px;
        background: white;
        z-index: 2;
        display: none;
        overflow-y: scroll;
    }

    #ajax table {
        margin-bottom: 40px;
    }

    /* IMPRESSÃO */
    /* 80 colunas */
    #imp80 {
        width: 27cm;
        margin: 20px auto;
        padding: 4px;
        font-family: "Lucida Console";
        font-size: 13px;
        font-weight: bolder;
        text-transform: uppercase;
    }

    #imp80 hr {
        border-top: 1px dashed #000;
        margin: 0;
    }

    .noprintable button {
        width: 100%;
    }

    .botoesImp button {
        font-size: 26px;
        text-transform: uppercase;
        cursor: pointer;
    }

    #cupom
        margin: 2px 0;
        border: 2px solid gray;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .printable, .printable * {
            visibility: visible;
        }

        .printable {
            margin: 0 auto !important;
            min-width: 100% !important;
            position: fixed;
            left: 0;
            top: 0;
        }

        .imp40 {
            font-size: 43px !important;
        }

        #imp80_ {
            font-size: 1.4em !important;
        }

        .noprintable {
            display: none;
            visibility: hidden;
        }

        @page {
            size: auto;
            margin: 0mm;
        }
    }

</style>
<script>
    /** Functions */
    // function modalClient(companyId, cnpjCpf, table) {
    //     if(companyId == "") {
    //         alertLatch("Nenhuma empresa foi selecionada", "var(--cor-warning)");
    //         return false;
    //     }
    //     $("#boxe_main").load("client", { companyId, cnpjCpf, table }, function() {
    //         $(this).on("click", "button", function() {
    //             let btnName = $(this).text();
    //             let dataForm = btnAction(btnName);
    //             if(dataForm) {
    //                 fillData(dataForm);
    //             }
    //         });
    //         $(".loading").hide();
    //         $("#boxe_main, #mask_main").show();
    //     });
    // }

    // function btnAction(name) {
    //     switch(name) {
    //         case "Selecionar":
    //             let typeForm = ($("#boxe_main #pj").css("display") === "none" ? "#pf" : "#pj");
	// 			if($("#boxe_main [name=CNPJ]").val().length == 0 && $("#boxe_main [name=CPF]").val().length == 0) {
	// 				return alertLatch("Não foi selecionado nenhum cliente", "var(--cor-warning)");
	// 			}
    //             return $("#boxe_main " + typeForm + " input").serializeArray();
    //             break;
    //         case "LIMPA BUSCA":
    //             $("#boxe_main input").val("");
    //             break;
    //     }
    // }

    // function fillData(data) {
    //     for(let x = 0; x < data.length; x++) {
    //         let name = changeName(data[x].name);
    //         $("#dClient [name=" + name + "]").val(data[x].value);
    //     }
    //     $("#boxe_main, #mask_main").hide();
    // }

    // function changeName(name) {
    //     switch(name) {
    //         case "Nome": case "RasSocial":
    //             return "NomeCliente";
    //             break;
    //         case "ID_PFISICA": case "ID_PJURIDICA":
    //             return "IDCliente";
    //             break;
    //         case "CPF": case "CNPJ":
    //             return "CNPJeCPF";
    //             break;
    //         default:
    //             return name;
    //     }
    // }

    // $(document).ready(function() {
    //     $("select[name=company-id]").on("change", function() {
    //         let dataSet = {
    //             companyId: $(this).val()
    //         };
    //         $.ajax({
    //             url: "transport",
    //             type: "POST",
    //             dataType: "JSON",
    //             data: dataSet,
    //             beforeSend: function() {
    //                 $(".loading, #mask_main").show();
    //                 $("select[name=IDTransportadora] option").remove();
    //             },
    //             success: function(response) {
    //                 let html = "<option value=''><option>";
    //                 for(let i in response) {
    //                     html += "<option value='" + response[i].IDTransportadora + "'>" + response[i].RasSocial + "</option>";
    //                 }
    //                 $("select[name=IDTransportadora]").append(html);
    //             },
    //             complete: function() {
    //                 $(".loading, #mask_main").hide();
    //             }
    //         });
    //     })
    //     $("#dClient .cSearch").on("click", function() {
    //         $(".loading").show();
    //         let companyId = $("#tabFiltroOrc select[name=company-id]").val();
    //         let cnpjCpf = $("#dClient input[name=CNPJeCPF]").val();
    //         let table = $("#dClient input[name=typeClient]:checked").attr("table");
    //         if(!modalClient(companyId, cnpjCpf, table)) {
    //             $("#tabFiltroOrc select[name=company-id]").css("background", "pink");
    //         }
    //     });
    //     $(document).on("keydown", function(e) {
    //         /** F1 */
    //         if(e.keyCode === 112) {
    //             $("#dClient .cSearch").trigger("click");
    //         }
    //     });
    // });
</script>
<div id="budget">
<nav id="filtroOrc">
    <table class='table-responsive' id='tabFiltroOrc' >
        <tr>
            <td class="pr-5" >
                Vendedor: <?= ($pedido->Vendedor ?? $salemanData->Logon) ?>
                <input name='Vendedor' type='hidden' value='<?= ($pedido->Vendedor ?? $salemanData->id) ?>'>
            </td>

            <!-- select Empresa -->
            <td class="pl-5" style="border-left: 1px solid">Empresa:</td>
            <td class="pr-5" style="border-right: 1px solid">
                <select name="company-id" >
                    <option value=""></option>
                    <?php if(!empty($companys)):
                        foreach($companys as $company): ?>
                        <option value="<?= ($company->ID ?? null) ?>"
                                <?= (!empty($pedido) && $pedido->IDEmpresa === $company->ID ? 'selected' : null) ?> >
                            <?= ($company->NomeFantasia ?? null) ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </td>
            <!-- <td class="pl-5 pr-5" style="border-left: 1px solid; padding-top: 11px" id="tipo" > -->
            <td class="pl-5 pr-5" id="tipo" >
                <input class="mr-1" type="radio" name="tipo" value="O" <?= ($reserva ?? null) ?> >
                Orçamento
                <input class="mr-1" type="radio" name="tipo" value="S" checked <?= ($simples ?? null) ?> >
                Orçamento sem Reserva
            </td>
            <td colspan="4" style="border-left: 1px solid; font-size: 1.2em;" align="right" class="pl-5" title="sair">
                <span> PEDIDOS & ORÇAMENTOS</span>
                <a href="<?= url('') ?>" class="sair" style="color: white">
                    <i class="fa fa-sign-out ml-2" ></i>
                </a>
            </td>
        </tr>
    </table>
</nav>

<section id="ancora" class="container-fluid" >
    <header id="acoes">
        <div class="row">
            <div id="acBusca" class="col" style="margin-top: 8px">
                <input type="text" name="busca" id="busca" autofocus value="<?= ($busca ?? null) ?>" style="height: 20px;">
                    <span class="btn btn-sm btn-secondary busca" >
                        <i class="fa fa-search" style="position:relative;top: -4px" ></i>
                    </span>
                    <!-- <span id="msg" style="color:red"> Nenhum dado foi encontrado.</span> -->
            </div>
            <div id="acBtn" class="col-lg-4 mt-2 col-sm-6">
                <button id="novo" class="btn btn-sm btn-outline-success"
                        style='height: 28px;font-size: 13px;
                        font-weight: bolder;position:relative;
                        top: -4px;'><i class="fa fa-plus-circle"></i>Novo</button>
                <button id="salvar" class="btn btn-sm btn-outline-success"
                        style='height: 28px;font-size: 13px;
                        font-weight: bolder;position:relative;
                        top: -4px;'><i class="fa fa-check-circle"></i>Salvar</button>
                <button id="excluir" class="btn btn-sm btn-outline-success"
                        style='height: 28px;font-size: 13px;
                        font-weight: bolder;position:relative;
                        top: -4px;'><i class="fa fa-minus-circle"></i>Excluir</button>
                <button id="imprimir" class="btn btn-sm btn-outline-secondary ml-4"
                        style='height: 28px;position:relative;
                        top: -4px;font-size: 13px;
                        font-weight: bolder'><i class="fa fa-print"></i>Imprimir</button>
            </div>
        </div>
        <div class="row" >
            <div class="col-8"></div>
            <div class="col-4 atalho" style="margin-top: -10px">
                <span style="margin-left: 2px" >(F4)</span>
                <span style="margin-left: 42px" >(F5)</span>
                <span style="margin-left: 50px" >(F6)</span>
                <span style="margin-left: 83px">(F7)</span>
            </div>
        </div>
    </header><!-- acoes -->

    <!-- dados e informações -->
    <section class="row form-inline" id="info">

        <div id="dClient" class="col-lg-4" >
            <div class="titulo">
                <div style="border-bottom: 1px solid black">Dados do Cliente
                    <button class="cSearch"><i class="fa fa-search"></i></button>
                    <span class="nCBusca atalho">(F1)</span>
                </div>
            </div>
            <div class="form-group dados">
                <label for="IDCliente">Nº Cliente: </label>
                <input type="text" name="IDCliente" value="<?= ($pedido->IDCliente ?? null) ?>" class="" size="5">
                <!-- <label for="TipoCliente">Tipo: </label>
                <input type="radio" name="typeClient" value="P. Física" class="ml-2" table="PFisica" > P. Física
                <input type="radio" name="typeClient" value="P. juridica" class="ml-1" table="PJuridica" checked="true" > P. Juridica -->
            </div>
            <div class="form-group">
                <label for="NomeCliente">Cliente: </label>
                <input type="text" name="NomeCliente" value="<?= ($pedido->NomeCliente ?? null) ?>" class="" style="text-align:left" size="40">
            </div>
            <div class="form-group">
                <label for="CNPJeCPF">CPF/CNPJ: </label>
                <input type="text" name="CNPJeCPF" value="<?= ($pedido->CNPJeCPF ?? null) ?>" class="" size="16" style="text-align:left">
                <label for="InscEstadual">Insc. Estad.: </label>
                <input type="text" name="InscEstadual" value="<?= ($pedido->InscEstadual ?? null) ?>" class="" size="6" style="text-align:left">
            </div>
            <div class="form-group pb-1">
                <label for="Bloqueio">Bloqueio: </label>
                <input type="text" name="Bloqueio" value="<?= ($pedido->Bloqueio ?? null) ?>" class="" size="1" style="text-align:left">
                <label for="Credito">Crédito: </label>
                <input type="text" name="Crédito" value="<?= ($pedido->Credito ?? '0,00') ?>" class="" size="4" style="text-align:left">
                <label for="pendencia">Pend.: </label>
                <input type="text" name="pendencia" value="<?= ($pedido->CreditoUtilizado ?? null); ?>" class="" size="6" style="text-align:left">
            </div>
            <!-- dados ocultos para Cupom -->
            <input type="hidden" name="Rua" value=""/>
            <input type="hidden" name="Num" />
            <input type="hidden" name="Complemento" />
            <input type="hidden" name="Bairro" />
            <input type="hidden" name="CEP" />
        </div><!-- dCliente -->

        <div id="dEntrega" class="col-lg-4 pb-1" >
            <div class="titulo">
                <div style="border-bottom: 1px solid black">Informações de Entrega</div>
            </div>
            <div class="form-group dados">
            <label for="Transportadora">Transportadora: </label>
            <select name="IDTransportadora" style="width: 250px; font-size:11px;font-weight: bolder"></select>
            </div>
            <div class="form-group">
            <label for="DataEntrega">Data Entrega: </label>
            <input type="date" name="DataEntrega" value="<?= ($pedido->DataEntrega ?? date('Y-m-d')) ?>" >
            <label for="HoraEntrega">Hora Entrega: </label>
            <input type="time" name="HoraEntrega" value="<?= ($pedido->HoraEntrega ?? date('H:i')) ?>">
            </div>
            <div class="form-group">
            <label for="Frete">Valor Frete: </label>
            <input type="text" name="Frete" value="<?= ($pedido->Frete ?? null) ?>" class="form-control-md" size="10">
            </div>
            <div class="form-group">
            <label for="TipoEntrega">Opção de Entrega: </label>
            <?php
                if(!empty($pedido) && $pedido->TipoEntrega == 1) {
                    $chec1 = 'checked';
                    $chec2 = null;
                } else {
                    $chec1 = null;
                    $chec2 = 'checked';
                }

            ?>

            <input type="radio" name="TipoEntrega" value="1" class="form-control-md" size="10" <?= $chec1 ?> > por conta(EMPRESA)
            <input type="radio" name="TipoEntrega" value="2" class="form-control-md" size="10" <?= $chec2 ?> > por conta(CLIENTE)
            </div>
        </div>

        <div id="detPedido" class="col-lg">
            <div class="form-group">
            <label for="DataVenda">Data Registro: </label>
            <span id="dataVenda" class="ml-2" style="font-size: 14px;">
                <?= ($pedido->DataVenda ?? date("d/m/Y H:i")) ?></span>
            </div>
            <div class="form-group">
            <label for="MONTAGEM">Montagem</label>
            <input type="checkbox" name="MONTAGEM" value="1" <?= (!empty($pedido) && $pedido->MONTAGEM == 1 ? 'checked' : null) ?> >
            <!--<label for="emitirNota" class="ml-2">Emitir Nota</label>
            <input type="checkbox" name="emitirNota" value="emitirNota"/>-->
            </div>
            <div class="form-group">
            <label for="Controle">Nº Controle: </label>
            <input type="text" name="Controle" value="<?= ($pedido->Controle ?? null) ?>" size="4"/>
            </div>
            <div class="form-group">

            <label for="VencOrcamento" style="color:red">Venc. Orçamento: </label>

            <input type="date" name="VencOrcamento" value="<?= ($vencOrcamento ?? null) ?>" size="4"/>

            </div>
            <div class="form-group">
            <label for="comprador">Comprador: </label>
            <input style="text-align:left" type="text" name="Comprador" value="<?= ($pedido->Comprador ?? null) ?>" size="17"/>
            </div>
        </div><!-- det Pedido -->

    </section><!-- info -->

    <!-- Produtos -->
    <section id="ltProd">
        <header class="row m-0">
            <h4 class="titulo">Lista de Produtos para Venda</h4>
            <div id="add" class="col mt-2" style="font-size:14px; cursor: pointer;" title="Adicionar Ítem"> <i class="fa fa-plus-circle"></i>
                <span class="atalho"> (F2)</span></div>
        </header>
        <article>
            <table class="table table-sm table-responsive" id="tabProd" width='100%'>
                <thead>
                    <tr>
                        <th>Ítem</th>
                        <th>Código</th>
                        <th width="800px">Descrição</th>
                        <th>Qtd</th>
                        <th>Desc.%</th>
                        <th width="80px">Valor Uni.</th>
                        <th width="85px">Valor Total</th>
                        <th>Estoque</th>
                        <th>Reservado</th>
                        <th>Comissão</th>
                        <th>Custo Médio</th>
                        <th title="Remove ítem" id="trash" width="5px"><button class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i></button></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $it=0;
                        if(isset($produto)):
                            $keys = array_keys($orcamento->getProduto());
                            for($x=0;$x<count($keys);$x++):
                                $it=$x; ?>

                    <tr id="<?= $x ?>" >
                        <td name="item" ><?= isset($produto) ?
                            $orcamento->getProduto()[$keys[$x]]->getItem() : null ?>
                        </td>
                        <td name="IDProduto" ><?= isset($produto) ?
                            $orcamento->getProduto()[$keys[$x]]->getIDProduto() : null ?>
                        </td>
                        <td name="Descricao" ><?= isset($produto) ?
                            $orcamento->getProduto()[$keys[$x]]->getDescricao() : null; ?>
                        </td>
                        <td name="qdt" >
                            <input size="1" type="text" name="qtd"
                                value="<?= isset($produto) ?
                                        intval($orcamento->getProduto()[$keys[$x]]->getQuantidade()) : null ?>" <?= $disabled ?>/>
                        </td>
                        <td name="desconto" >
                            <input size="2" type="text" name="desconto"
                                value="<?= isset($produto) ?
                                        number_format($orcamento->getProduto()[$keys[$x]]->getDesconto(),'1','.','') :
                                                    null ?>" <?= $disabled ?> />
                        </td>
                        <td name="valor" >
                            <input size="4" name="valor" type="text" custo="<?= $orcamento->getProduto()[$keys[$x]]->getCustoProd() ?>" comissao="<?= $orcamento->getProduto()[$keys[$x]]->getComissao() ?>"  value="<?= isset($produto) ? number_format($orcamento->getProduto()[$keys[$x]]->getValorProdReal(),'2',',','.') : null ?>" <?= $disabled ?> />
                        </td>
                        <td name="totalItem" ><?= isset($produto) ?
                            number_format($orcamento->valorTotalItem($keys[$x]),'2',',','.') : null ?>
                        </td>
                        <td name="EstAtual" ><?= isset($produto) ?
                                "<span>" . number_format($orcamento->getProduto()[$keys[$x]]->getEstAtual(),'0','','.') . "</span>" : null ?>
                        </td>
                        <td name="reserva" ><?= isset($produto)
                                && $orcamento->getProduto()[$keys[$x]]->getReserva()
                                    != '' ? $orcamento->getProduto()[$keys[$x]]->getReserva() : '-' ?>
                        </td>
                        <td name="comissao" ><?= isset($produto) ?
                                number_format($orcamento->getProduto()[$keys[$x]]->getComissao(),'2',',','.') : null ?>
                        </td>
                        <td name="custoMedio"><?= isset($produto) ?
                                number_format($orcamento->getProduto()[$keys[$x]]->getCustoProd(),'2',',','.') : null ?>
                        </td>
                        <td name="remove"><?= $button ?></td>
                    </tr>
                    <?php endfor; endif; ?>
                </tbody>
            </table>
        </article>
        <footer id='resumo' class="mt-2">
	        <h4 class='titulo row'>Resumo</h4>
            <div class='row ml-0 mr-0'>
                <div class='col-md-1' style='border:1px solid #ccc;'>Ítens:<br>
                    <span style="font-size:13px;float:right" id="totalItem">
                        <?= ($totalItens ?? null) ?>
                    </span>
                </div>
                <div class='col-md-2 col-xs-12' style='border:1px solid #ccc'> Perc. Lucro:<br>
                    <span style="font-size:13px;color:green;float:right" id="percLucro">
                        <?= ($percLucro ?? null) ?>%
                    </span>
                </div>
                <div class='col-md-2' style='border:1px solid #ccc'>Lucro:<br>
                    <span style="font-size:13px;float:right;color:green" id="lucro">
                        <?= ($lucro ?? null) ?>
                </div>
                <div class='col-md-2' style='border:1px solid #ccc'>Total Produto:<br>
                    <span style="font-size:13px;color: black; float:right" id="totalProduto">
                        <?= ($TotalProduto ?? null) ?>
                    </span>
                </div>
                <div class='col-md-2' style='border:1px solid #ccc'>
                    Total Desconto:<br>
                    <span style="font-size:13px;color:red;float:right" id="totalDesconto"><?= ($pedido->Desconto ?? null) ?>
                    </span>
                </div>
                <div class='col-md-1' style='border:1px solid #ccc'>Frete:<br>
                    <span style="font-size:13px;float:right" id="frete"><?= ($pedido->Frete ?? null) ?>
                    </span>
                </div>
                <div class='col-md-2' style='border:1px solid #ccc; background: rgba(255,255,0,0.5)'>Valor Pedido:<br>
                    <span style="font-size:13px;color:blue;float:right" id="totalPedido">
                            <!-- <?= ($TotalProduto-$pedido->Desconto ?? null) ?> -->
                    </span>
                </div>
            </div>
        </footer><!-- Totais -->
    </section><!-- ltProd -->

    <section id="posResumo" class="row mt-4 ml-2">
        <div id="obs" class="col-lg-5">
            <label>OBS.:</label>
            <textarea name="OBS" placeholder="" cols="80" rows="4"><?= ($pedido->OBS ??'Garantia legal 3 Meses (90 dias) Estabelecida pelo CDC (Código de Defesa do Consumidor)') ?>
            </textarea>
        </div>

        <!-- Pagamento -->
        <div class="col-lg-4 col-md-6" >
            <table id="tabPag" class="table compact display"
                style="width: 100%; margin-left: 0px; font-size: 11px;">
                <thead>
                    <tr>
                    <th style="text-align:center">Nº</th>
                    <th style="text-align:center">Vencimento</th>
                    <th style="text-align:center; white-space: nowrap">
                        Valor a Receber
                    </th>
                    <th style="text-align:center; white-space: nowrap">
                        Tipo Pagamento
                    </th>
                    <th style="text-align:center">Forma Pagamento</th>
                    <th style="text-align:center">Tipo Pagamento</th>
                    <th style="text-align:center">Bandeira</th>
                    <th style="text-align:center">FatorTaxa</th>
                    <th style="text-align:center">ID Bandeira</th>
                    </tr>
                </thead>

                <?php if(!empty($FormaPagamento) && isset($FormaPagamento[$pedido->getFormaPagamento()]) && !isset($copy)):
                        $v = explode('-',$FormaPagamento[$pedido->getFormaPagamento()]->getVencimento());

                        if(count($v)>1) {
                            $vencimento=substr($v[2],0,2).'/'.$v[1].'/'.$v[0];
                        }

                        $numDoc = $FormaPagamento[$pedido->getFormaPagamento()]->getNumDoc();
                        $tipoBandeira = $FormaPagamento[$pedido->getFormaPagamento()]->getBandeira(); ?>
                <tbody>
                    <tr>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?= isset($vencimento) ?
                                $vencimento : null; ?>
                        </td>
                        <td style="text-align:center">
                            <?= number_format($FormaPagamento[$pedido
                                    ->getFormaPagamento()]->getValor(),2,',','.') ?>
                        </td>
                        <td style="text-align:center">
                            <?= $FormaPagamento[$pedido->getFormaPagamento()]
                                ->getTipoPag() ?>
                        </td>
                        <td style="text-align:center">
                            <?= $FormaPagamento[$pedido->getFormaPagamento()]
                                ->getDescricao() ?>
                        </td>
                        <td style="text-align:center">
                            <?= $FormaPagamento[$pedido->getFormaPagamento()]
                                ->getTipoPag() ?>
                        </td>
                        <td style="text-align:center">
                            <?= isset($tipoBandeira) ?
                                $ban[$tipoBandeira] : null ?>
                        </td>
                        <td style="text-align:center">
                            <?= $FormaPagamento[$pedido->getFormaPagamento()]
                                ->getFator().','.$FormaPagamento[$pedido
                                    ->getFormaPagamento()]->getTaxa() ?>
                        </td>
                        <td style="text-align:center">
                            <?= $FormaPagamento[$pedido->getFormaPagamento()]
                                ->getBandeira() ?>
                        </td>
                    </tr>
                </tbody>
                <?php endif; ?>
            </table>
        </div>
        <div class="col-lg-1 col-md-1 col-xs-1" >
            <button id="btnPagamento" class="btn-sm btn-info rotation"
                style="font-size:10px; font-weight: 900; cursor: pointer">
                    PAGAMENTO
            </button>
            <span style="position:relative;top: 23px; left: 8px" class="atalho">
                (F3)
            </span>
        </div>
        <div id="doc" class="form-horizontal col col-md-2" >
            <div class="form-group" style="font-size:11px; font-weight: 700;">
                <label>Nº Doc:</label>
                <input style="font-size:11px;height: 20px;" size="10"
                    class="form-control-sm" name="NumDoc" type="text"
                    value="<?= ($numDoc ?? null) ?>"/>
            </div>
        </div>
    </section><!-- row -->

</section><!-- container-fluid -->
</div> <!-- budget -->

<!-- Janelas Modais -->
<div id='ajax'>
    <div><h3>Relatório do Banco</h3></div>
    <table id='tabAjax' class='display'>
	<thead>
	    <tr>
		<th align="center" >Tabela</th>
		<th align="center" >Pedido</th>
		<th align="center" >Valor</th>
		<th align="center" >Empresa</th>
		<th align="center" >Parcela</th>
	    </tr>
	</thead>
    </table>
</div>

<!-- <div class="mask2"></div> -->

<div id="boxes">
    <!-- Janela Modal -->
    <div id="dialog" class="window"></div>
    <!-- Fim Janela Modal-->

    <!-- Máscara para cobrir a tela -->
    <!-- <div id="mask"></div> -->
</div>
<div id="boxes2">
    <!-- Janela Modal -->
    <div id="dialog2" class="window2"></div>
    <!-- Fim Janela Modal-->

    <!-- Máscara para cobrir a tela -->
    <!-- <div id="mask2"></div> -->
</div>
<div id="boxes3">
    <!-- Janela Modal -->
    <div id="dialog3" class="window3"></div>
    <!-- Fim Janela Modal-->

    <!-- Máscara para cobrir a tela -->
    <!-- <div id="mask3"></div> -->
</div>

<script>
    var pedido = "<?= $pedido->getPedido() ?>";
    var cnpjCpf = "<?= $pedido->getCNPJeCPF() ?>";
</script>

<!-- caixa de dialogo -->
<div id="div_dialogo" >
    <div class="faixa">&nbsp</div>
    <span id="dMsg"></span>
</div>

<!-- Modal HTML -->
<div id="imp40" class="modal printable"></div>
<!-- mudança do tipo de relatório -->
<div id="imp80" class="modal printable"></div>

<!-- <script type="text/javascript" src="../assets/scriptOrcamento.js"></script> -->
