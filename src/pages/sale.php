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

#tabFiltro tbody {
    margin: 0 auto;
}

#filtroGerVenda {
    background: #007ce2;
}

#ajax {
    display: none;
    width: 90%;
    margin: 15px auto;
}

#ajax table {
    margin: 0 auto;
}

#ajax h6 {
    text-align: center;
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

</style>
    <div style="background: #007ce2">
        <form method="post" action="<?= url("gerenciamento/vendas") ?>" id="filtroGerVenda" class='topBack form-inline'>
            <table class='table-responsive' id="tabFiltro" style="display: flex;">
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
    <div id='ajax' >
        <h6>Relatório de Resposta do Banco de Dados</h6>
        <table id='tabAjax' class='display' style="white-space: nowrap;" >
            <thead>
                <tr>
                <?php foreach($titlesTableAjax as $title): ?>
                    <th><?= $title ?></th>
                <?php endforeach ?>
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
