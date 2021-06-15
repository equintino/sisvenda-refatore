<style>

/* @import url('https://fonts.googleapis.com/css?family=Open+Sans|Source+Code+Pro&display=swap'); */
/* @import url("../web/fonts"); */

body {
    padding: 0;
    margin: 0;
    font-size: 11px;
    -webkit-font-smoothing: antialiased !important;
}

.body {
    background: white;
}

/** custom top */
#top {
    display: none;
}

.topBack {
    color: white;
    font-size: 11px;
    text-shadow: 1px 1px 1px black;
    width: 100%;
    padding: 6px 0;
}

#filtroGerVenda {
    background: #007ce2;
    padding-left: 20px;
}

#ajax {
    margin-top: 50px;
    display: none;
    width: 600px;
    margin: 20px auto;
}

/* progress datatable */
.progress, .progress + span {
    position: fixed;
    width: 20%;
    top: 40%;
    left: 40%;
    z-index: 9;
}

.progress + span {
    margin-top: 13px;
    color: white;
    font-size: 1.1em;
    font-weight: 600;
    letter-spacing: .1rem;
    text-shadow: 1px 1px 1px black;
    font-style: italic;
}

@keyframes fa-blink {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
}

.fa-blink {
  -webkit-animation: fa-blink 1.4s linear infinite;
  -moz-animation: fa-blink 1.4s linear infinite;
  -ms-animation: fa-blink 1.4s linear infinite;
  -o-animation: fa-blink 1.4s linear infinite;
  animation: fa-blink 1.4s linear infinite;
}

form table#tabSale td {
    padding: 4px 9px;
}

#busca {
    border-radius: 5px 0 0 5px;
}

#btnBusca {
    border-radius: 0 5px 5px 0;
    margin-left: -4px;
    margin-top: 3px;
    padding: 4px 8px 3px;
}

button:hover {
    cursor: pointer;
}

table#tabSale {
    max-height: 420px;
}

table#tabSale tbody {
    border: 4px solid gray;
}

/* table#tabSale tbody tr {
    background: #ffffff;
}

table#tabSale tbody .odd {
    background: #f9f9f9;
} */

table#tabSale td, table#tabSale th {
    white-space: nowrap;
    max-width: 500px;
    overflow: hidden;
    text-overflow: ellipsis;
}

table#tabSale input {
    font-size: 11px;
}

td.details-control {
    background: url(<?= theme("assets/img/details_open.png") ?>) no-repeat center center;
    background-size: 16px;
    cursor: pointer;
}

tr.details td.details-control {
    background: url(<?= theme('assets/img/details_close.png') ?>) no-repeat center center;
    background-size: 16px;
    cursor: pointer;
}

table.dataTable {
    border-bottom: 1px solid #ccc;
}

.corVencido {
    color: red;
    text-shadow: none;
}

.fGerOrc span {
    padding: 0 20px;
}

.vrlTotals {
    font-size: 13px;
}

.btnAction {
    position: relative;
    /* z-index: 2; */
    background-color: #fcfcfc;
    background: linear-gradient(to bottom, #fcfcfc 5%, #eaeaea 70%);
    cursor: pointer;
    text-decoration: none;
    text-shadow: 0px 1px 0px #e1e2ed;
    font-family:Arial;
    padding: 5px;
    border: 1px solid rgba(060, 060, 060, 0.3);
    display:inline-block;
    box-shadow: 1px 2px 0px 0px #899599;
}

.btnAction:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom,
        color-stop(0%, #fff), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -moz-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -ms-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -o-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: linear-gradient(to bottom, #f6f6f6 0%, #e3e3e3 100%)
}

.btnAction:active {
    border: 1px solid #426c9e;
    background-color: #e4e4e4;
    background: -webkit-gradient(linear, left top, left bottom,
        color-stop(0%, #e4e4e4), color-stop(100%, #cfcfcf));
    background: -webkit-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -moz-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -ms-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -o-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: linear-gradient(to bottom, #e4e4e4 0%, #cfcfcf 100%);
    box-shadow: inset 0 0 3px #111;
}

.page-link {
    color: #000;
    background-color: #fff;
    border: none;
    padding: 5px 10px;
}

.page-item.active .page-link {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear,  left top,  left bottom,  color-stop(0%,  white),  color-stop(100%,  #dcdcdc));
    background: -webkit-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -moz-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -ms-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -o-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: linear-gradient(to bottom,  white 0%,  #dcdcdc 100%);
    box-shadow: none;
}

.page-link:active {
    cursor: default;
    color: #666 !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
}

.page-link:hover {
    color: white !important;
    border: 1px solid #111;
    background-color: #585858;
    background: -webkit-gradient(linear,  left top,  left bottom,  color-stop(0%,  #585858),  color-stop(100%,  #111));
    background: -webkit-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -moz-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -ms-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -o-linear-gradient(top,  #585858 0%,  #111 100%);
    background: linear-gradient(to bottom,  #585858 0%,  #111 100%);
}

.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: red;
    border-color: none;
    box-shadow: none;
}

/* .page-link.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear,  left top,  left bottom,  color-stop(0%,  white),  color-stop(100%,  #dcdcdc));
    background: -webkit-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -moz-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -ms-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: -o-linear-gradient(top,  white 0%,  #dcdcdc 100%);
    background: linear-gradient(to bottom,  white 0%,  #dcdcdc 100%);
} */

/* .dataTables_wrapper .dataTables_paginate .paginate_button:hover, .page-link:hover {
    color: white !important;
    border: 1px solid #111;
    background-color: #585858;
    background: -webkit-gradient(linear,  left top,  left bottom,  color-stop(0%,  #585858),  color-stop(100%,  #111));
    background: -webkit-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -moz-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -ms-linear-gradient(top,  #585858 0%,  #111 100%);
    background: -o-linear-gradient(top,  #585858 0%,  #111 100%);
    background: linear-gradient(to bottom,  #585858 0%,  #111 100%);
} */
/* .dataTables_wrapper .dataTables_paginate .paginate_button:active, .page-link.active {
    outline: none;
    background-color: #2b2b2b;
    background: -webkit-gradient(linear,  left top,  left bottom,  color-stop(0%,  #2b2b2b),  color-stop(100%,  #0c0c0c));
    background: -webkit-linear-gradient(top,  #2b2b2b 0%,  #0c0c0c 100%);
    background: -moz-linear-gradient(top,  #2b2b2b 0%,  #0c0c0c 100%);
    background: -ms-linear-gradient(top,  #2b2b2b 0%,  #0c0c0c 100%);
    background: -o-linear-gradient(top,  #2b2b2b 0%,  #0c0c0c 100%);
    background: linear-gradient(to bottom,  #2b2b2b 0%,  #0c0c0c 100%);
    box-shadow: inset 0 0 3px #111;
} */





#total {
        font-size: 12px;
        background: #0059e0;
        padding: 5px 0;
        color: white;
        margin: -1px auto;
        z-index: 3;
}

#total table {
    margin: 0 auto;
}

#total table td {
    padding-left: 25px;
}

.footLeft {
    float: left;
    margin: 10px 0 0 35px;
}

.footCenter {
    width: 70%;
    margin: auto;
    display: inline-block;
    border-left: 1px solid white;
    border-right: 1px solid white;
}

.footCenter span {
    padding-left: 20px;
}

.footCenter hr {
    border-top: 1px solid white;
    margin: 3px auto;
}

.footRight {
    float: right;
    margin: 10px 30px 0 0;
}

form {
    padding-bottom: 5px;
}

.dataTables_length, #tabSale_filter {
    margin-top: 15px;
    font-size: 11px;
}

.dataTables_length label, #tabSale_filter label {
    font-size: 11px;
    color: black;
}

#tabSale_length .custom-select, #tabSale_filter label input {
    height: 20px;
    padding-top: 0;
    margin-top: 0px;
    font-size: 11px;
}

#bottoms {
    float: left;
    margin-top: -9px;
}

#hideSelection {
    display: flex;
    justify-content: end;
    margin-top: 15px;
}

#tabSale .selected {
    color: white;
}

#tabSale tbody tr {
    cursor: pointer;
}

/* #topheader {
    background: #196430;
    font-size: 14px;
    padding-left: 20px;
} */

/* a.nav-link img, #sair {
    height: 15px;
} */

/* a.nav-link#login,
a.nav-link#seguranca,
a.nav-link#sair_,
.sair {
    font-size: 15px;
    color: #8db298;
    margin-top: 3px
} */

/* a.nav-link#sair_, .sair {
    font-size: 18px;
}

a.nav-link#login:hover,
a.nav-link#seguranca:hover,
a.nav-link#sair_:hover,
.sair:hover {
    color: #C5D8CB;
    cursor: pointer;
} */


/* home */
/* div.container span.initial {
    float: right;
    font-size: 14px;
    margin-top: -50px;
    font-weight: 600;
}

table#tabFiltro {
    width: 1400px;
    margin: 0 auto;
} */


/* #filtroOrc {
    background: green;
    letter-spacing: 1px;
    font-size: 13px;
    color: white;
    padding: 0px 20px;
} */

/* table#tabFiltroOrc {
    width: 1250px;
    margin: 0 auto;
    padding-left: 40px;
} */

/* #filtroGerEntrega {
    background: #800000;
    letter-spacing: 1px;
} */

/* #filtroGerOrc {
    background: #916F33;
    letter-spacing: 1px;
} */

/* #filtroAltPreco {
    background: #FC7F17;
    letter-spacing: 1px;
    margin-bottom: 5px;
    padding-left: 45px;
} */

/* #flashes {
    text-align: center;
    font-size: 20px;
    color: white;
    background: red;
} */

/* exibir um loading */
/* #mask {
    background: rgba(0, 0, 0, 0.048);
    position: fixed;
    z-index : 2;
    height: 100%;
    width: 100%;
} */

/* aguarde */
/* .lendo {
    position: fixed;
    top: 30%;
    left: 40%;
    z-index: 3;
    font-size: 40px;
    font-family: "Source Code Pro";
} */

/* gif */
/* .lendo2 {
    position: fixed;
    top: 28%;
    left: 38%;
    z-index: 4;
} */

/* nav.btn {
    color: white;
} */

/* #identificacao {
    text-align: right;
} */

/* #identificacao, fieldset legend {
    margin-right: 30px;
    font-size: 15px;
    font-weight: 600;
} */

/* .config a {
    margin-left: -15px;
} */

/* formatar form */
/* form input {
    font-size: 11px;
    text-transform: uppercase;
}

.noprintable button {
    width: 100%;
} */

/* button stylization */
/* .btnAction {
    position: relative;
    background-color: #fcfcfc;
    background: linear-gradient(to bottom, #fcfcfc 5%, #eaeaea 70%);
    cursor: pointer;
    text-decoration: none;
    text-shadow: 0px 1px 0px #e1e2ed;
    font-family: Arial;
    padding: 5px;
    border: 1px solid rgba(060, 060, 060, 0.3);
    display: inline-block;
    box-shadow: 1px 2px 0px 0px #899599;
}

.btnAction:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom,
        color-stop(0%, #fff), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -moz-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -ms-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: -o-linear-gradient(top, #f6f6f6 0%, #e3e3e3 100%);
    background: linear-gradient(to bottom, #f6f6f6 0%, #e3e3e3 100%)
}

.btnAction:active {
    border: 1px solid #426c9e;
    background-color: #e4e4e4;
    background: -webkit-gradient(linear, left top, left bottom,
        color-stop(0%, #e4e4e4), color-stop(100%, #cfcfcf));
    background: -webkit-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -moz-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -ms-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: -o-linear-gradient(top, #e4e4e4 0%, #cfcfcf 100%);
    background: linear-gradient(to bottom, #e4e4e4 0%, #cfcfcf 100%);
    box-shadow: inset 0 0 3px #111;
} */

/* botton red */
/* .save {
    font-weight: 900;
    letter-spacing: .8px;
    cursor: pointer;
    color: white;
    background-color: black;
    background: linear-gradient(to bottom, white 0%, red 30%);
    text-shadow: 0px 1px 0px red;
    border: 1px solid rgba(060, 060, 060, 0.3);
    box-shadow: 1px 2px 0px 0px #404040;
}

.save:hover {
    color: #333 !important;
    background-color: white;
    background: linear-gradient(to bottom, white 0%, red 30%);
    text-shadow: 0px 1px 0px white;
    border: 1px solid rgba(060, 060, 060, 0.3);
    box-shadow: 1px 2px 0px 0px #404040;
}

.cancel {
    cursor: pointer;
    font-weight: 900;
    letter-spacing: .8px;
    color: white;
    background-color: gray;
    background: linear-gradient(to bottom, white 0%, gray 30%);
    text-shadow: 0px 1px 0px black;
    border: 1px solid rgba(060, 060, 060, 0.3);
    box-shadow: 1px 2px 0px 0px #404040;
}

.cancel:hover {
    color: #333 !important;
    background-color: gray;
    background: linear-gradient(to bottom, white 0%, gray 30%);
    text-shadow: 0px 1px 0px gray;
    border: 1px solid rgba(060, 060, 060, 0.3);
    box-shadow: 1px 2px 0px 0px #404040;
} */


/* Janela */
/* #boxe_main {
    display: none;
    position: absolute;
    top: 15%;
    left: 10%;
    max-height: 450px;
    width: 80%;
    margin:  auto;
    background: #f5f5f5;
    z-index: 2;
    padding: 10px;
}

#mask_main {
    display: none;
    position:absolute;
    left:0;
    top:0;
    width: 100%;
    height: 100%;
    z-index: 1;
    background: rgba(0,0,0,0.4);
} */

/* caixa de dialogo */
/* #div_dialogo {
    display: none;
    max-width: 600px;
    font-size: 16px;
    min-height: 100px;
    font-family: "Source Code Pro";
}

#div_dialogo .faixa {
    background:  #004080;
    width: 120%;
    margin-top: -15px;
    margin-left: -30px;
}

#div_dialogo #dMsg {
    color: black;
}

#div_dialogo .close-modal {
    margin: 15px 15px 0 0;
    background-size: 23px
} */

/* Window(select company) */
/* .mask {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.window {
    position: relative;
    top: -200px;
    margin: auto;
    width: 70%;
    height: 200px;
    text-align: center;
    background: whitesmoke;
    z-index: 2;
}

.window > div {
    padding-top: 30px;
}

.window > div > select {
    margin-top: 10px;
} */




/* #topo, .window
{
    display: none;
} */




    /* #topo, .window {
        display: none;
    }

    form table td {
        padding: 0 2px;
    }

    #busca {
        border-radius: 5px 0 0 5px;
    }

    #btnBusca {
        border-radius: 0 5px 5px 0;
        margin-left: -4px;
        margin-top: 3px;
        padding-top: 4px;
        padding-bottom: 3px;
    }

    .screen {
        margin-top: 10px;
    }

    button:hover {
        cursor: pointer;
    }

    table#tabGer {
        max-height: 420px;
    }

    table#tabGer td, table#tabGer th {
        white-space: nowrap;
        max-width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    table#tabGer input {
        font-size: 10px;
    }*/

    /*table.tabDetail, table.tabDetail th, table.tabDetail td {
        border: 1px solid gray;
    }

    table.tabDetail th {
        background: #eee;
    }

    td.details-control {
        background: url('../web/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.details td.details-control {
        background: url('../web/img/details_close.png') no-repeat center center;
    }

    .corVencido {
        color: red;
        text-shadow: none;
    }

    .corRed {
        color: red;
    }

    .corBlue {
        color: blue;
    }

    .fGerOrc span {
        padding: 0 20px;
    }

    .vrlTotals {
        font-size: 13px;
    } */

    /* IMPRESSÃO */
    /* 80 colunas */
    /* #imp80 {
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

    #cupom {
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
            position: fixed;
            left: 0;
            top: 0;
        }

        .noprintable {
            display: none;
            visibility: hidden;
        }

        @page {
            size: auto;
            margin: 0mm;
        }

        @media print {
            .imp40 {
                font-size: 33px !important;
            }
        } */
}

</style>
<!-- <div class="container mt-5"> -->
    <!-- <link rel="stylesheet" href="../assets/styleGer.css">
    <link rel="stylesheet" href="../assets/styleVenda.css"> -->

    <?php //require __DIR__ . "/../includes/venda.php"; ?>

    <!--<div class="topBack">-->
    <!-- <div class="filtro"> -->
    <div>
        <form method="post" action="<?= url("gerenciamento/vendas") ?>" id="filtroGerVenda" class='topBack form-inline'>
            <table class='table-responsive' id="tabFiltro">
                <tr>
                    <td><input type="radio" name="tBusca" value="Pedido" checked/></td>
                    <td>Nº Pedido</td>
                    <td><input type="radio" name="tBusca" value="NFNum" <?= isset($tBusca) && $tBusca === 'NFNum' ? 'checked' : null; ?> /></td>
                    <td>Nº NF</td>
                    <td><input type="radio" name="tBusca" value="CNPJeCPF" <?= isset($tBusca) && $tBusca === 'CNPJeCPF' ? 'checked' : null; ?> /></td>
                    <td>CPF/CNPJ</td>
                    <td><input type="radio" name="tBusca" value="NomeCliente" <?= isset($tBusca) && $tBusca === 'NomeCliente' ? 'checked' : null; ?>/></td>
                    <td>Cliente</td>
                    <td align="right" style="border-left: 1px solid white">Empresa:</td>
                    <td><select name="companies" style="width: 160px">
                            <option value=""></option>
                        </select></td>
                    <td align='right' >Dt. Reg.:</td>
                    <td style="border-right: 1px solid"><input class="data" type='date' name='dtInicio' value="<?= $dtInicio ?? null ?>" ></td>
                    <td colspan="2" align='right' style="border-left: 1px solid; padding-left: 5px">Situação:</td><td>
                        <select name="situacao" >
                            <option value=""></option>
                                <?php foreach ($sitList as $v): ?>
                                    <option value="<?= $v ?>" <?= isset($situacao) && $v === $situacao ? "selected" : null ?> ><?= $v ?></option>
                                <?php endforeach ?>
                        </select>
                    </td>
                    <td style="text-align:right; border-left: 1px solid white"><input type="checkbox" name="desativado" value="1" <?= isset($desativado) ? 'checked' : null ?> /></td>
                    <td class="pr-1" colspan="2">Desativado</td>
                    <td colspan="3" style="border-right: 1px solid"></td>
                    <td class="pl-1" colspan="4" align="right">GERENCIADOR DE VENDAS<a href="<?= url("") ?>" ><i class="fa fa-sign-out sair pl-2" style="color: white"></i></a></td>
                </tr>
                <tr>
                    <td align="right" colspan="7"><input type="search" name="busca" id="busca" size="36" value="<?= $busca ?? null ?>" autofocus/></td>
                    <td align="left" class="pr-1"> <button type="submit" class="fa fa-search btn-md btn-dark pt-1" id="btnBusca" ></button></td>
                    <td align='right' class="pl-1" style="border-left: 1px solid">Vendedor:</td>
                    <td><select name="saleman" <?= empty($IDEmpresa) ? "disabled" : null; ?> >
                            <option value=""></option>
                        </select>
                    </td>
                    <td align='right' >Até:</td>
                    <td class="pr-1"><input class="data" type='date' name='dtFim' value="<?= isset($dtFim) ? $dtFim : null ?>"  /></td>
                    <td style="border-left: 1px solid white" align="right">Status: </td>
                    <td colspan="2" style="border-right: 1px solid; padding-right: 5px;">
                        <select name="status">
                            <option value=""></option>
                            <?php foreach($sts as $k => $v): ?>
                            <option value="<?= $k ?>" <?= isset($status) && $status  === $k ? "selected" : null ?> ><?= $v ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td style="padding-left: 5px; border-left: 1px solid white"><input type="checkbox" name="pg" value="1" <?= isset($pg) ? "checked" : null ?> /></td>
                    <td align="right">Pago: </td>
                    <td><input type="radio" name="pago" value="1" checked <?= isset($pago) && $pago == 1 ? "checked" : "disabled" ?> /></td>
                    <td>Sim</td>
                    <td><input type="radio" name="pago" value="0" <?= isset($pago) && $pago == "0" ?"checked" : "disabled" ?> /></td>
                    <td style="border-right: 1px solid white">Não</td>
                    <td class="pl-1"><input type="radio" name="activeSale" value=1 <?= (empty($vAtiva) || $vAtiva == 1 ? 'checked' : null) ?>/></td>
                    <td>Vendas Ativas</td>
                    <td><input type="radio" name="activeSale" value=0 <?= (isset($vAtiva) && $vAtiva == 0 ? "checked" : null) ?>/></td>
                    <td>Vendas Canceladas</td>
                </tr>
            </table>
        </form>
    </div>

    <div class="container-fluid" >
        <section id="bottoms">
            <button class=btnAction onclick="return false" >Abrir</button>
            <!--&nbsp<button class=btnAction onclick="return false">Copiar</button>-->
            <button class=btnAction onclick="return false" >Imprimir</button>
            <button class=btnAction onclick="return false" >Cancelar</button>
        </section>
        <div id="hideSelection" >Ocultar Coluna:
            <select name="colunas">
                <option value=""></option>
            </select>
        </div>
        <form action="#" id="altOrc" enctype="multipart/form-data" method="POST">
            <table id="tabSale" class="table-striped compact display nowrap" width="100%" >
                <thead>
                    <tr>
                        <th></th>
                            <?php if (isset($columns)):
                                $x = 1;
                                foreach ($columns as $column):
                                    ($align = $x !== 4 ? "style='text-align: center'" : null); ?>
                                    <th <?= $align ?> ><?= (array_key_exists($x, $chTitles)?$chTitles[$x] : $column) ?></th>
                                    <?php $x++;
                                endforeach;
                            endif; ?>
                        <th style="text-align:center"><i class="fa fa-paperclip"></i>Arquivos</th>
                        <th>Documentos</th>
                        <th>Produto</th>
                    </tr>
                </thead>
            </table>
        </form>
    </div><!-- screen -->

    <div id="total"></div>

    <button id="btnAlt" style="float:right; margin-right: 10px; border-radius: 0 0 5px 5px" class="btn-md btn-dark">Gravar Alteração</button>

    <!-- Janelas Modais -->
    <div id='ajax' style="width: 90%">
        <div style="text-align: center">
            <h5>Relatório de Resposta do Banco de Dados</h5>
        </div>
        <table id='tabAjax' class='display' >
            <thead>
                <tr>
                    <th style="text-align:center">Pedido</th>
                    <th style="text-align:center">Controle</th>
                    <th style="text-align:center;white-space: nowrap;">Nº NF</th>
                    <th style="text-align:center">Venc. Orcamento</th>
                    <th style="text-align:center;white-space: nowrap;">Custo Venda</th>
                    <th style="text-align:center">Situação</th>
                    <th style="text-align:center">Desativado</th>
                    <th style="text-align:center">Pago</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center;white-space: nowrap;">Código Correio</th>
                    <th style="text-align:center;width:10%">Obs</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="window"></div>

    <!-- Modal HTML -->
    <div id="imp40" class="modal printable"></div>
    <!-- mudança do tipo de relatório -->
    <div id="imp80" class="modal printable"></div>

    <!-- <script src="../assets/scriptVenda.js"></script> -->

<!-- </div> -->
