<!-- <link rel="stylesheet" type="text/css" href="../assets/styleCadastro.css" /> -->
<?php //require __DIR__ . "/../includes/cadastro.php"; ?>
<?php if( $act === 'cad_cliente' || $act === "cad_fornecedor" || $act === "cad_transportadora" ): ?>

    <?php $pag = ( $act === "cad_cliente" ?
            "CLIENTE" : ( $act === "cad_fornecedor" ?
                "FORNECEDOR" : "TRANSPORTADORA" ) ) ?>

        <!-- Seleção do tipo do formulário -->
        <script>var identificacao = "CADASTRO DE <?= $pag ?>";</script>
        <script>cnpj = "<?= $cnpj ?>";</script>
        <script>cpf = "<?= $cpf ?>";</script>
        <?php if( $act === "cad_cliente" ): ?>
        <div class="form-group form-horizontal row preForm">
            <div class="col-md-3 col-sm-auto ml-4">
                <label for="tipo"
                    class="form-check-label col-form-label-sm ml-4">
                        Tipo do Formulário: </label>
                <select class="form-control-sm" id="tipo" name='tipoForm'>
                    <!-- <option <?= $pf ?> value='pf'>Pessoa Fisica</option>
                    <option <?= $pj ?> value='pj'>Pessoa Jurídica</option> -->
                </select>
            </div>
            <div class="col-md-6 col-sm-auto">
                <label for="transp"
                    class="form-check-label col-form-label-sm ml-2">
                        Transportadora: </label>
                <select class="form-control-sm" id="transp">
                    <option>SEM FRETE</option>
                    <?php foreach ($transp as $key => $value): ?>
                        <option value="<?= $key ?>"
                            <?= $selIdTransp($IDTransportadora) === $key ?
                                    "selected" : null; ?> >
                                        <?= $value["RasSocial"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- select transportadora -->
        </div>
        <?php else: ?>
        <div class="marginForm"></div>
        <?php endif; ?>

        <!-- formulario PF -->
        <form class="form form-horizontal" id="pf" method="POST" action="#" >
            <!-- Dados Pessoa Física -->
            <input type="hidden" name="IDTransportadora" value="1" />
            <input type="hidden" name="IDEmpresa" value="1" />
            <div class="formCad row">
                <fieldset class="col mr-2 pt-4">
                    <legend>IDENTIFICAÇÃO</legend>
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label class="form-group-label" for="cpf">
                                CPF: <i class="fa fa-search searchCpf"></i>
                            </label>
                            <!-- <input id="cpf" name="CPF" class="form-control" type="text" required="required" value="<?= $cpf ?>"/> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-group-label" for="nome">
                                Nome: </label>
                            <!-- <input id="nome" name="Nome" class="form-control" type="text" required="required" value="<?= $nome ?>"/></div> -->
                        <div class="col-md">
                            <label class="form-group-label" for="nascimento">
                                Data de Nascimento:
                            </label>
                            <!-- <input id="nascimento" name="DataNasc" class="form-control" type="text" value="<?= $dtNasc ?>" /></div> -->
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label class="form-group-label" for="tel">
                                Telefone: </label>
                            <!-- <input id="tel" name="TelResid" class="form-control" type="tel" value="<?= formataTel($telResid) ?>"/> -->
                        </div>
                        <div class="col-md">
                            <label class="form-group-label" for="tel">
                                Celular: </label>
                            <input id="cel" name="Celular" class="form-control" type="tel" required="required" value="<?= formataTel($celular) ?>"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-group-label" for="email">
                                E-mail: </label>
                            <input id="email" name="Email" type="email"
                                class="form-control" required="required"
                                    value="<?= $email ?>"
                                        style="text-transform: lowercase"/>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="col">
                    <legend>LOCALIZAÇÃO</legend>
                    <div class="form-group form-row">
                        <div class="col-md-2" >
                            <label for="CEP" class="col-form-label-sm mt-3"
                                style="font-size: 12px">
                                    CEP: <i class="fa fa-search searchCep"></i>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input id="cepBusca" name="CEP" type="text"
                                class="form-control-sm" maxlength="9" />
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label for="Rua">Endereço: </label>
                            <input class="form-control" id="endereco"
                                name="Rua" required="required"
                                    value="<?= $endereco ?>"/>
                        </div>
                        <div class="col-md-2">
                            <label for="Num">Nº: </label>
                            <input class="form-control" id="numero" name="Num"
                                required="required" value="<?= $num ?>"/>
                        </div>
                        <div class="col-md-2">
                            <label for="Complemento">Complemento: </label>
                            <input class="form-control" id="complemento"
                                name="Complemento" value="<?= $complemento ?>"/>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label for="Bairro">Bairro: </label>
                            <input class="form-control" id="bairro"
                                name="Bairro" required="required"
                                    value="<?= $bairro ?>"/>
                        </div>
                        <div class="col-md">
                            <label for="Cidade">Cidade: </label>
                            <input class="form-control" id="cidade"
                                name="Cidade" required="required"
                                    value="<?= $cidade ?>" />
                        </div>
                        <div class="col-md-1">
                            <label for="UF">UF: </label>
                            <input class="form-control" id="uf" name="UF"
                                required="required" value="<?= $uf ?>"/>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-2">
                            <label for="CEP">cep: </label>
                            <input class="form-control" id="cep" name="CEP"
                                required="required" value="<?= $cep ?>"/>
                        </div>
                    </div>
                </fieldset>
            </div><!-- row -->
            <div class="botao col-md-2 col-sm-auto mr-4" >
                <button class="cancel" type="reset"
                    style="" >Limpar
                </button>
                <button class="save" type="submit"
                    onclick="return false" >Salvar
                </button>
            </div>
        </form>
        <!-- formulario PJ -->
        <form class="form-horizontal" id="pj" method="POST" action="#" >
            <!-- Dados Pessoa Jurídica -->
            <input type="hidden" name="IDTransportadora" value="1" />
            <input type="hidden" name="IDEmpresa" value="1" />
            <input type="hidden" name="Tipo" id="tipo" value="<?= $tipo ?>"
                class="form-control" />
            <div class="formCad row">
                <fieldset class="col">
                    <legend>IDENTIFICAÇÃO</legend>
                    <div class="form-group form-row">
                        <div class="col-md-3">
                            <label>CNPJ: <i class="fa fa-search searchCnpj"></i>
                            </label>
                            <input type="text" name="<?= $identCnpj[0] ?>"
                                id="cnpj" value="<?= formataCnpj($cnpj) ?>"
                                    class="form-control" autofocus
                                        required="required"/>
                        </div><!-- col -->
                        <div class="col-md">
                            <label for="NomeFantasia">Nome Fantasia: </label>
                            <input type="text" name="<?= $identCnpj[1] ?>"
                                id="<?= $identCnpj[1] ?>"
                                    value="<?= $fantasia ?>"
                                        class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label for="InscEstadual">Inscrição Estadual: </label>
                            <input type="text" name="<?= $identCnpj[7] ?>"
                                id="InscEstadual" value="<?= $inscEst ?>"
                                    class="form-control"/>
                        </div>
                    </div><!-- form row -->
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label>Razão Social: </label>
                            <input type="text" name="<?= $identCnpj[2] ?>"
                                id="RasSocial" value="<?= $rasSocial ?>"
                                    class="form-control" required="required"/>
                        </div>
                        <div class="col-md-3">
                            <label>Telefone: </label>
                            <input size=15 name="<?= $identCnpj[3] ?>"
                                id="telefonePJ" required="required"
                                    value="<?= $tel01 ?>" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Celular: </label>
                            <input size=15 name="Tel02" id="celularPJ"
                                value="<?= $tel02 ?>" class="form-control"/>
                        </div>
                    </div><!-- form row -->
                    <div class="form-group form-row">
                        <?php if( $act === "cad_cliente" ): ?>
                        <div class="col-md-6">
                            <label>Sócio(QSA): </label>
                            <input type="text" size="90" name="qsa" id="qsa"
                                value="<?= $socio ?>" class="form-control" />
                        </div>
                        <?php endif; ?>
                        <div class="col-md">
                            <label>E-mail: </label>
                            <input type="email" name="<?= $identCnpj[4] ?>"
                                id="Email" required="required"
                                    value="<?= $emailPJ ?>" class="form-control"
                                        style="text-transform: lowercase"/>
                        </div>
                        <div class="col-md-3">
                            <label>Contato: </label>
                            <input type="text" size="40" name="Contato"
                                id="contato" required="required"
                                    value="<?= $contato ?>"
                                        class="form-control" />
                        </div>
                    </div><!-- form row -->
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label>Site: </label>
                            <input size=15 name="HomePage" id="homePage"
                                value="<?= strtolower($site) ?>"
                                    class="form-control"
                                        style="text-transform: lowercase"/>
                        </div>
                        <div class="col-md">
                            <label>Atividade Principal: </label>
                            <input type="text" name="<?= $identCnpj[5] ?>"
                                id="Atividade" value="<?= $atv ?>"
                                    class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label>Status: </label>
                            <div class="form-group">
                                <input type="text" name="<?= $identCnpj[6] ?>"
                                    value="<?= $situacao ?>"
                                        class="form-control" />
                            </div><!-- form group -->
                        </div>
                    </div><!-- form row -->
                </fieldset>
                <fieldset class="col ml-2">
                    <legend>LOCALIZAÇÃO</legend>
                    <!-- busca endereço por CEP -->
                    <div class="form-group form-row">
                        <div class="col-md-2" >
                            <label for="cep" class="col-form-label-sm mt-2"
                                style="font-size: 12px">
                                    CEP: <i class="fa fa-search searchCep"></i>
                            </label>
                        </div>
                        <div class="col-md-2" align="left">
                            <input id="cepBuscaPJ" name="cep" type="text"
                                class="form-control-sm" maxlength="9" />
                        </div>
                    </div><!-- busca CEP -->
                    <div class="form-group form-row">
                        <div class="col-md-7">
                            <label>Endereço: </label>
                            <input type="text" name="<?= $endCnpj[0] ?>"
                                id="ruaPJ" required="required"
                                    value="<?= $end ?>" class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <label>N°: </label>
                            <input size="5" type="text"
                                name="<?= $endCnpj[1] ?>" id="numPJ"
                                    required="required" value="<?= $numero ?>"
                                        class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Complemento: </label>
                            <input size="15" type="text"
                                name="<?= $endCnpj[2] ?>" id="complementoPJ"
                                    value="<?= $complementoPJ ?>"
                                        class="form-control"/>
                        </div>
                    </div><!-- form row-->
                    <div class="form-group form-row">
                        <div class="col-md">
                            <label>Bairro: </label>
                            <input size="20" type="text"
                                name="<?= $endCnpj[3] ?>" id="bairroPJ"
                                    required="required"
                                        value="<?= $bairroPJ ?>"
                                            class="form-control"/>
                        </div>
                        <div class="col-md">
                            <label>Cidade: </label>
                            <input size="20" type="text"
                                name="<?= $endCnpj[4] ?>" id="cidadePJ"
                                    required="required"
                                        value="<?= $cidadePJ ?>"
                                            class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <label>Estado: </label>
                            <input size="5" type="text"
                                name="<?= $endCnpj[5] ?>" id="ufPJ"
                                    required="required" value="<?= $ufPJ ?>"
                                        class="form-control"/>
                        </div>
                    </div><!-- form row -->
                    <div class="form-group form-row">
                        <div class="col-md-3">
                            <label>Cep: </label>
                            <input size="20" type="text" name="CEP" id="cepPJ"
                                required="required" value="<?= $cepPJ ?>"
                                    class="form-control"/>
                        </div>
                    </div><!-- form row -->
                </fieldset>
            </div><!-- formCad -->
            <div class="botao col-md-2 col-sm-auto mr-4" >
                <button class="cancel" type="reset" >
                    Limpar</button>
                <button onclick="return false" class="save"
                    type="submit" >Salvar</button>
            </div>
        </form>
        <div id='status'></div>
<?php endif; ?>
<script type="text/javascript" src="../assets/scriptCadastro.js" ></script>
