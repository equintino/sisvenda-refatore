<?php

    // use Dao\Dao;
    // use Dao\CriterioBusca;

    // $cnpj = filter_input(INPUT_GET, 'cnpj');
    // $cpf = filter_input(INPUT_GET, 'cpf');
    // $act = filter_input(INPUT_GET, 'act');

    // $dao = new Dao();
    // $search = new CriterioBusca();

    /* funcões */
    function formataTel($num) {
        if (preg_match('/^\(/', $num) == 0 && $num != null) {
            return '(00)' . $num;
        }

        $num = str_replace(' ', '', $num);
        $suf = strstr($num, ')');
        $ddd = substr(strstr($num, ')', true), -2, 2);

        if (!$suf) {
            return $num;
        }

        return '(' . $ddd . $suf;
    }

    function formataCnpj($n) {
        return ( !$n ? '' : $n[0] . $n[1] . '.' . $n[2] . $n[3] . $n[4]
                . '.' . $n[5] . $n[6] . $n[7] . '/' . $n[8]
                . $n[9] . $n[10] . $n[11] . '-' . $n[12] . $n[13] );
    }

    /* Pesquisa dados PJ */
    function getCnpj($cnpj) {
        $ch = curl_init("https://www.receitaws.com.br/v1/cnpj/" . $cnpj);

        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);
        $dColetado = json_decode($output);

        $campos = array();
        $dados = array();

        if ($dColetado):
            foreach ($dColetado as $key => $item) {
                if ($key != 'atividade_principal'
                    && $key != 'atividades_secundarias' && $key != 'qsa'
                        && $key != 'extra') {
                    $dados[$key] = $item;
                    $campos[$key] = $item;
                } elseif ($key == 'atividade_principal') {
                    foreach ($item[0] as $key2 => $item2) {
                        $dados[$key][$key2] = $item;
                    }
                } elseif ($key == 'atividades_secundarias') {
                    foreach ($item as $item2) {
                        foreach ($item2 as $key3 => $item3) {
                            $dados[$key][$key3] = $item3;
                        }
                    }
                } elseif ($key == 'qsa') {
                    foreach ($item as $item2) {
                        foreach ($item2 as $key3 => $item3) {
                            $dados[$key][$key3] = $item3;
                        }
                    }
                } elseif ($key == 'extra') {
                    foreach ($item as $key2 => $item2) {
                        $dados[$key][$key2] = $item2;
                    }
                }
            }

            if (!@is_numeric($dados['cnpj'][0])) {
                return $dados = null;
            }
            return $dados;
        endif;
    }

    $selIdTransp = function($id) {/*return Cnpj da transportadora*/
        foreach( $_SESSION["Transportadora"] as $k => $v ) {
            if( $id === $v->IDTransportadora ) {
                return $v->Cnpj;
            }
        }
    };
    /* FIM Funções */

    /* buscar no banco cpf digitado */
    if ( isset($cpf) ) {
        $search->setTabela('PFisica');
        $search->setTop(1);
        $search->setArray(array('CPF' => $cpf));

        $cpfEncontrado = $dao->encontre($search);

        if ($cpfEncontrado) {
            $idCpf = key($cpfEncontrado);
            $cpf = $cpfEncontrado[$idCpf]->getArray()['CPF'];
            $dtNascArr = explode('-', substr($cpfEncontrado[$idCpf]
                ->getArray()['DataNasc'], 0, 10));
            $dtNasc = $dtNascArr[2] . '/' . $dtNascArr[1] . '/' . $dtNascArr[0];
            $nome = $cpfEncontrado[$idCpf]->getArray()['Nome'];
            $telResid = $cpfEncontrado[$idCpf]->getArray()['TelResid'];
            $celular = $cpfEncontrado[$idCpf]->getArray()['Celular'];
            $email = $cpfEncontrado[$idCpf]->getArray()['Email'];
            $endereco = $cpfEncontrado[$idCpf]->getArray()['Rua'];
            $num = $cpfEncontrado[$idCpf]->getArray()['Num'];
            $complemento = $cpfEncontrado[$idCpf]->getArray()['Complemento'];
            $bairro = $cpfEncontrado[$idCpf]->getArray()['Bairro'];
            $cidade = $cpfEncontrado[$idCpf]->getArray()['Cidade'];
            $uf = $cpfEncontrado[$idCpf]->getArray()['UF'];
            $cep = $cpfEncontrado[$idCpf]->getArray()['CEP'];
            $IDTransportadora = $cpfEncontrado[$idCpf]
                ->getArray()['IDTransportadora'];
        }

        echo "<script>var cpf='{$cpf}'</script>";

    } elseif ( !empty( $cnpj ) ) {/* buscando no banco CNPJ digitado */
        if( $act === "cad_fornecedor" ) {
            $search->setTabela('Fornecedor');
            $$cnpj = "CNPJ";

        } elseif( $act === "cad_transportadora" ) {
            $search->setTabela('Transportadora');
            $$cnpj = "Cnpj";

        } else {
            $search->setTabela('PJuridica');
            $$cnpj = "CNPJ";
        }

        $search->setArray( array( $$cnpj => formataCnpj($cnpj) ) );
        $search->setTop(1);

        $cnpjEncontrado = $dao->encontre($search);

        if( $cnpjEncontrado ) {
            $idPJuridica = key($cnpjEncontrado);
            $cnpjDb = $cnpjEncontrado[$idPJuridica]->getArray();
        }
    }

    /* Atribuindo nulos aos valores inexistentes Pessoa Física */
    $dtNasc = isset($dtNasc) ? $dtNasc : null;
    $nome = isset($nome) ? $nome : null;
    $telResid = isset($telResid) ? $telResid : null;
    $celular = isset($celular) ? $celular : null;
    $email = isset($email) ? $email : null;
    $endereco = isset($endereco) ? $endereco : null;
    $num = isset($num) ? $num : null;
    $complemento = isset($complemento) ? $complemento : null;
    $bairro = isset($bairro) ? $bairro : null;
    $cidade = isset($cidade) ? $cidade : null;
    $uf = isset($uf) ? $uf : null;
    $cep = isset($cep) ? $cep : null;
    $IDTransportadora = isset($IDTransportadora) ? $IDTransportadora : null;

    $x = 0;
    $y = 0;

    /* Define se o formulário é pj ou pf */
    $pj = isset($cnpj) ? 'selected' : null;
    $pf = isset($cpf) ? 'selected' : null;

    /* obtendo dados de Pessoa Jurídica da Receita Federal */
    if ( isset($cnpj) ) {
        $dados = getCnpj($cnpj);

        if ( isset($cnpjDb) ) {/* campos em branco no Banco de Dados completa-los com os dados
         * vindo da receita */
            $IDTransportadora = array_key_exists("IDTransportadora" , $cnpjDb) ?
                $cnpjDb["IDTransportadora"] : null;
            $rasSocial = $cnpjDb['RasSocial'];
            $tel_ = $cnpjDb['Tel01'];
            $tel02 = $cnpjDb['Tel02'];
            $emailPJ = $cnpjDb['Email'];
            $contato = $cnpjDb['Contato'];
            $end = $cnpjDb['Rua'];
            $numero = $cnpjDb['Num'] == '' ? $dados['numero'] : $cnpjDb['Num'];
            $complementoPJ = $cnpjDb['Complemento'] == '' ?
                $dados['complemento'] : $cnpjDb['Complemento'];
            $bairroPJ = $cnpjDb['Bairro'];
            $cidadePJ = $cnpjDb['Cidade'];
            $ufPJ = $cnpjDb['UF'];
            $site = $cnpjDb['HomePage'];

            $atv = array_key_exists("Atividade", $cnpjDb) ?
                $cnpjDb['Atividade'] : null;

            $fantasia = array_key_exists("NomeFantasia", $cnpjDb) ?
                $cnpjDb['NomeFantasia'] : null;

            $socio = array_key_exists("Sócio01", $cnpjDb) ?
                $cnpjDb['Sócio01'] : (
                    isset($dados) && array_key_exists("qsa", $dados) ?
                        $dados['qsa']['nome'] : null
                    );

            $cepPJ = array_key_exists("CEP", $cnpjDb) ?
                $cnpjDb['CEP'] : (
                    array_key_exists("Cep", $cnpjDb) ?
                        $cnpjDb["Cep"] : null
                    );

            $inscEst = array_key_exists("InscEstadual", $cnpjDb) ?
                $cnpjDb['InscEstadual'] : (
                    array_key_exists("InscEsdatual", $cnpjDb) ?
                        $cnpjDb["InscEsdatual"] : null
                    );
        }

        /* adcionando dados encontrados na Receita Federal */
        $fantasia = isset($fantasia) ? $fantasia : $dados['fantasia'];
        $rasSocial = isset($rasSocial) ? $rasSocial : $dados['nome'];
        $tel = substr(($dados['telefone']), 0, 14);
        $tel_ = isset($tel_) ? $tel_ : $tel;
        $emailPJ = isset($emailPJ) ? $emailPJ : $dados['email'];

        if (isset($dados['qsa'])) {
            $socio = isset($socio) ? $socio : $dados['qsa']['nome'];
        }

        $end = isset($end) ? $end : $dados['logradouro'];
        $numero = isset($numero) ? $numero : $dados['numero'];
        $complementoPJ = isset($complementoPJ) ?
            $complementoPJ : $dados['complemento'];
        $bairroPJ = isset($bairroPJ) ? $bairroPJ : $dados['bairro'];
        $cidadePJ = isset($cidadePJ) ? $cidadePJ : $dados['municipio'];
        $ufPJ = isset($ufPJ) ? $ufPJ : $dados['uf'];
        $cepPJ = isset($cepPJ) ? $cepPJ : $dados['cep'];

        if (isset($atv)) {
            $atv = $atv;
        } else {
            $atv = is_object($dados['atividade_principal']['text'][0]) ?
                $dados['atividade_principal']['text'][0]->text : $atv = null;
        }
        $tipo = $dados['tipo'];
        $situacao = $dados['situacao'];
    }

    /* Atribuindo nulo aos valores inexistentes - Pessoa Jurídica */
    $fantasia = isset($fantasia) ? $fantasia : null;
    $tel01 = isset($tel_) ? formataTel($tel_) : null;
    $tel02 = isset($tel02) ? $tel02 : null;
    $emailPJ = isset($emailPJ) ? $emailPJ : null;
    $end = isset($end) ? $end : null;
    $numero = isset($numero) ? $numero : null;
    $complementoPJ = isset($complementoPJ) ? $complementoPJ : null;
    $bairroPJ = isset($bairroPJ) ? $bairroPJ : null;
    $cidadePJ = isset($cidadePJ) ? $cidadePJ : null;
    $ufPJ = isset($ufPJ) ? $ufPJ : null;
    $cepPJ = isset($cepPJ) ? $cepPJ : null;
    $inscEst = isset($inscEst) ? $inscEst : null;
    $rasSocial = isset($rasSocial) ? $rasSocial : null;
    $contato = isset($contato) ? $contato : null;
    $socio = isset($socio) ? $socio : null;
    $atv = isset($atv) ? $atv : null;
    $tipo = isset($tipo) ? $tipo : null;
    $situacao = isset($situacao) ? $situacao : null;
    $site = isset($site) ? $site : null;
    $IDTransportadora = isset($IDTransportadora) ? $IDTransportadora : null;

    $campoCnpj = Array('data_situacao', 'complemento', 'situacao', 'abertura',
        'natureza_juridica', 'ultima_atualizacao', 'status', 'efr',
        'motivo_situacao', 'situacao_especial', 'data_situacao_especial',
        'capital_social');

    $identCnpj = array('cnpj', 'NomeFantasia', 'RasSocial', 'Tel01', 'Email',
        'Atividade', 'StatusAtivo', 'InscEstadual', 'HomePage');

    if( $act === "cad_transportadora" ) {
        $identCnpj[1] = "RasSocial";
        $fantasia = $rasSocial;
    }

    $endCnpj = array('Rua', 'Num', 'Complemento', 'Bairro', 'Cidade', 'UF',
        'CEP');

    $outrosCnpj = array('Vendedor', 'Bloqueio', 'Crédito', 'Revenda',
        'IDTransportadora', 'IDEmpresa', 'ECF', 'LIMITE_CAIXAS', 'Conceito');

    //$transp = $_SESSION["Transportadora"];

    if( $act === "cad_cliente" ) {
        /* Definindo empresa/id Transportadora */
        //$search->setTabela('Transportadora');
        //$search->setArray(array());
        if( !empty($_SESSION["Transportadora"]) ) {
            foreach ( $_SESSION["Transportadora"] as $key => $value ) {
                $cnpjTransp = $value->Cnpj != "" ?
                    $value->Cnpj : 'SEM_FRETE';
                $transp[$cnpjTransp] = array( 'RasSocial' => $value->RasSocial,
                    'IDEmpresa' => $value->IDEmpresa, "Cnpj" => $value->Cnpj,
                        "IDTransportadora" => $value->IDTransportadora );
            }
        }
    }
