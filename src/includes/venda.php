<?php
/**
 * include gerenciamento de venda
 */

// use Dao\CriterioBusca;
// use Classes\NSession;
// use Classes\Mensagem;
// use Classes\Situation;
// use Classes\Status;
// use Controller\VendaController;
// use Controller\ProdutoVendaController;
// use Controller\CadArquivoController;

// $mensagem = new Mensagem();
// $nSession = new NSession();
// $venda = new VendaController();
// $produto = new ProdutoVendaController();

// $act = filter_input(INPUT_GET, "act");
// $IDEmpresa = filter_input(INPUT_GET,"IDEmpresa");
// $IDEmpresa = isset($IDEmpresa) ? $IDEmpresa : filter_input(INPUT_POST, "IDEmpresa");

/**
 * Cria um array de vendedores
 * @var type $dVend
 */
// foreach ($_SESSION["Vendedor"] as $k => $v) {
//     if( ( isset($IDEmpresa) && $v->IDEmpresa == $IDEmpresa ) || $IDEmpresa == '' ) {
// 	    $dVend[$k] = $v;
//     }
// }

//$dEmp = $_SESSION["empresa"];

// $tBusca = filter_input(INPUT_POST, "tBusca");
// $busca = filter_input(INPUT_POST, "busca");
// $pg = filter_input(INPUT_POST, "pg");
// $desativado = filter_input(INPUT_POST, "desativado");
// $vendedor = filter_input(INPUT_POST, "vendedor");
// $pago = filter_input(INPUT_POST, "pago");
// $dtInicio = filter_input(INPUT_POST, "dtInicio");
// $dtFim = filter_input(INPUT_POST, "dtFim");
// $situacao = filter_input(INPUT_POST, "situacao");
// $status = filter_input(INPUT_POST, "status");
// $vCancelada = filter_input(INPUT_POST, "vCancelada");
// $vAtiva = filter_input(INPUT_POST, "vAtiva");

// $tBusca = isset($tBusca) ? $tBusca : "Pedido";

/**
 * Função anônima
 * @$vendedor = busca
 * @$dVend = Array do banco
 */
// $idVend = function() use ($vendedor, $dVend) {
//     foreach($dVend as $v) {
//         if( $vendedor === $v->LogON ) {
//             return $v->ID_Vendedor;
//         }
//     }
// };

// $situation = new Situation();
// $sitList = $situation->getStage();

// $statusObj = new Status();
// $sts = $statusObj->getStatus();

// $formatTab = function($x, $value) {
//     global $dVend;
//     global $sitList;
//     global $sts;

//     switch($x) {
//         case 1:/* input Controle */
//             $resp = "<input name=Controle type=text value='{$value}' size=6>";
//             break;
//         case 2:/* input Nota Fiscal */
//             $resp = "<input name=NFNum type=text value='{$value}' size=6>";
//             break;
//         case 5:/* data */
//             $resp = date("d/m/Y", strtotime($value));
//             break;
//         case 6:/* horário */
//             $resp = substr(explode(" ",$value)[1],0,5);
//             break;
//         case 7:/* data vencimento */
//             $alert = strtotime($value) - strtotime(date("Y-m-d")) < 0 ?
//                         "class = corVencido" : null;
//             $resp = "<input type='date' name='VencOrcamento' {$alert} value={$value} >";
//             break;
//         case 8:/* Situação */
//             $resp  = "<select name=Situacao >";
//             foreach($sitList as $i) {
//                 $resp .= "<option value='{$i}' " . $selected = $i === $value ?
//                             "selected" : null;
//                 $resp .= ">{$i}</option>";
//             }

//             $resp .= "</select>";
//             break;
//         case 9:/* Desativar */
//             $checked = $value == 1 ? "checked" : null;
//             $resp = "<input type='checkbox' name='DESATIVO' value=1 " . $checked . ">";
//             break;
//         case 10:/* Pago */
//             $checked = $value == 1 ? "checked" : null;
//             $resp = "<input type='checkbox' name='PAGO' value=1 " . $checked . ">";
//             break;
//         case 11: case 15: case 16:/* numero Real */
//             $resp = is_numeric($value) ? number_format($value,2,',','.') : $value;
//             break;
//         case 12:/* Tipo (status) */
//             $resp  = "<select name=Status>";
//             foreach($sts as $k => $v) {
//                 if($k !== "C" && $k !== "CO") {
//                     $selected = $value === $k ? 'selected' : null;
//                     $resp .= "<option value='{$k}' {$selected}>{$v}</option>";
//                 }
//             }
//             $resp .= "</select>";
//             break;
//         case 13:/*Custo Venda*/
//             $resp = "<input class='corRed' type=text name='CustoVenda' size=6 value='";
//             $resp .= number_format($value, 2,",",".") . "'>";
//             break;
//         case 17:/* Código correio */
//             $resp = "<input type=text name='NUM_RASTREIOCORREIOS' size=12 value='";
//             $resp .= $value . "'>";
//             break;
//         case 18:/* Origem */
//             $resp = $value !== null ? "EXTERNO" : "INTERNO";
//             break;
//         default:
//             $resp = $value;
//     }

//     return $resp;
// };


// $calcComis = function($vlr, $data) {
//     return number_format($data * $vlr / 100,"2",",",".");
// };

// !empty($IDEmpresa) ? $buscaArr["Venda.IDEmpresa"] = $IDEmpresa : null;
// !empty($busca) ? $buscaArr["Venda.".$tBusca] = $busca : null;
// !empty($idVend()) ? $buscaArr["Venda.Vendedor"] =  $idVend() : null;
// !empty($pg) ? $buscaArr["Venda.PAGO"] =  $pago : null;
// !empty($desativado) ? $buscaArr["Venda.DESATIVO"] =  $desativado : null;
// !empty($situacao) ? $buscaArr["Venda.Situação"] =  $situacao : null;

// if(!empty($status)) {
//     $buscaArr["Venda.Status"] =  $status;
// }

// !empty($vAtiva) == 0 ? $buscaArr["Venda.DataCancelado"] =  1
//     : $buscaArr["Venda.DataCancelado"] =  0;
// !empty($dtInicio) ? $buscaArr["dtInicio"] =  $dtInicio : null;
// !empty($dtFim) ? $buscaArr["dtFim"] =  $dtFim : null;

/* busca dados do banco */
//$filtro = "Item,IDProduto,Descrição,UniMedida,Quantidade,Valor";

/**
 * Inclusão no script scriptVenda
 */
//echo "<script>var filtro = 'Item,Cód. Produto,Descrição,Un. Medida,Qtd,Valor';</script>";

// $exCampos = "'InscEstadual','HoraVenda','FormaPagamento','TipoPagamento',"
//     . "'TipoEntrega','DescontoPorc','Transportadora','DolarHoje','DolarCliente',"
//     . "'MONTAGEM','PROPAGANDA','Viavel','InfoLogin','TemEntrega','INFOPAGO',"
//     . "'PDV','EQUIP','SANGRIA','CupomECF','UltimaAlteracao','UserUltimaAlteracao',"
//     . "'VAL_AUX_ICMS','VAL_AUX_ICMS_ST','Num_Qtd_Volumes','COD_EXTERNO_SCWEB',"
//     . "'AguardandoPagamentoWeb','SemCadastro','Manter_Financeiro_Venda',"
//     . "'OBS2','Serie_Cupom','COD_FORNECEDOR','IDVenda_NEW',TabVenda,Desconto,OBS,"
//     . "Comprador,VALE,DataEntrega,HoraEntrega,USUARIO,"
//     . "DataCancelado,FATURAR";

/** fields displayed in the table */
// $campos = "Pedido,Controle,NFNum,NomeCliente,CNPJeCPF,DataVenda,HoraVenda,"
//     . "Vendedor,Situação,DESATIVO,PAGO,Valor,Status,CustoVenda,"
//     . "TabComissao,CreditoUtilizado,Frete,NUM_RASTREIOCORREIOS,ORIGEM,IDCliente,"
//     . "TipoCliente,IDEMPRESA,OBS";

// $cols = explode(",", $campos);
// $cols2 = explode(",", $filtro);

// if(isset($buscaArr)) {
//     $search->setArray($buscaArr);
// } else {
//     $search->setArray(array());
// }

// if(isset($act) && $act === "filtro") {
//     $search->setTop(150);
//     $venda->find($search)->setFiltro($campos);
//     $dados = $venda->find($search)->getFiltro();
// }

// $chTitles = [
//         1   => "Pedido",
//         2   => "Nº Controle",
//         3   => "Nota Fiscal",
//         4   => "Nome Cliente",
//         5   => "CNPJ/CPF",
//         6   => "Data Reg.",
//         7   => "Horário",
//         8   => "Vendedor",
//         9  => "Situação",
//         10  => "Desativar",
//         11  => "Pago",
//         12  => "Valor",
//         13  => "Status",
//         14  => "Custo Venda",
//         15  => "Comissão",
//         16  => "Créd. Dev.",
//         17  => "Frete",
//         18  => "Código Correio",
//         19  => "Origem",
//         20  => "Cód. Cliente",
//         21  => "Tipo Cliente",
//         22  => "Empresa",
//         23  => "OBS"
//     ];

/* alinhamento do texto na tabela */
// $alignExcept = [ 3,11 ];
// $alignRight = [ 11,14,17 ];

// $prod = function($pedido) {
//     global $produto;
//     global $filtro;
//     $search = new CriterioBusca();
//     $search->setArray(array(
//         "Pedido" => $pedido["Pedido"],
//         "IDEmpresa" => $pedido["IDEMPRESA"]
//     ));

//     $search->setTop(0);
//     $produto->find($search)->setFiltro($filtro);
//     $response = $produto->find($search)->getFiltro();

//     return isset($response) ? $response : null;
// };

// $image = function($v) {
//     $cadArquivo = new CadArquivoController();
//     $search = new CriterioBusca();

//     $codDocumento = $v->getArray()["Pedido"];
//     $codEmpresa = $v->getArray()["IDEMPRESA"];
//     $search->setTabela("CadArquivos");
//     $search->setArray(array("COD_DOCUMENTO" => $codDocumento,
//         "COD_EMPRESA"=> $codEmpresa, "IND_LOCAL" => 5));

//     $listImg = $cadArquivo->listImage($search);

//     if(isset($listImg) && $listImg !== null) {
//         foreach($listImg as $v_) {
//             $resp[] = $v_;
//         }
//     }

//     return isset($resp) ? $resp : null;
// };

//echo "<script>var login = '{$_SESSION["login"]}'</script>";
