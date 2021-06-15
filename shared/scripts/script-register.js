$(document).ready(function() {
    /** loading image adjust */
    if(typeof(page) !== "undefined" && page.toLowerCase() === "cliente") {
        $(".loading").css("top","50%");
    }

    /* general forms configuration */
    var formAtivo = "pj";
    var corBack = '#faffbd';
    var ident;
    if(typeof(identification) !== "undefined") {
        ident = identification.split(' ');
        cad = ident[ident.length-1];
    }// else {
    //     identification = null;
    // }

    /* fundo foco */
    $("input").blur(function() {
        $(this).css("background","white");
    });

    $("input").focus(function() {
        $(this).css("background",corBack);
    });

    $('select#tipo').change(function() {
        $("#pj, #pf").find("input").val("");
        if($(this).val() === 'pf') {
            $('#pf').show();
            $('#pj').hide();
            $('input[name=CPF]').focus();
            formAtivo = "pf";
        } else {
            $('#pf').hide();
            $('#pj').show();
            $('input[name=CNPJ]').focus();
            formAtivo = "pj";
        }
    });

    $("button[type=reset]").click(function() {
        return $("form").find("input").val("");
    });

    /* Validação de CPF */
    $('form input[name=CPF]').on("keyup", function(e) {
        var cpf = validCPF( $(this).val() );

        if( cpf.length === 14 ) {
            buscaCpf(formAtivo, cpf);
        }
    });

    $("input#cepBusca, input#cepBuscaPJ").on("keyup", function(e) {
        if( $(this).val().length === 8 ) {
            buscaCep(this, formAtivo);
        }
    });

    $('#tel').on("keyup", function(e) {
        var tel = $(this).val();
        if(tel.length === 13) {
            if($(this).val().length === 14 || $(this).val().length === 13) {
                $('input#email').css('background',corBack).focus();
            }
        }
    });

    $('input[name=CNPJ').on("keyup", function() {
        var cnpj = $(this).val();
        if( cnpj.length  === 18 ) {
            buscaCnpj(formAtivo, cnpj);
        }
    });

    $("form#pf button[type=submit], form#pj button[type=submit]").click( function() {
        /** confirmar proposito */
        if(this["id"] === "cad_pessoa") {
            formAtivo = "acesso";
        }

        var campos = $("form[id=" + formAtivo + "] input[required=required]");
        var ok = null;

        campos.each(function() {
            if($(this).val() === '') {
                var cp = $(this).attr('name');

                alertLatch("O campo <span style='color: red'>" + cp + "</span> é obrigatório.", "var(--cor-warning)");
                ok = 0;
                $(this).css("background",corBack).focus();
                return false;
            }
        });

        if(ok !== 0) {
            var data = $("form[id=" + formAtivo + "]").serialize();
            var actButton = $(this).text().toLowerCase();
            saveAjaxData(data, actButton);
        }
    });

    /* mascara */
    $("#nascimento").mask("00/00/0000");
    $("#cpf").mask("000.000.000-00");
    $('#tel').mask("(00)0000-0000");
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cel').mask("(00)00000-0000");

    $('select[id=transp]').on("change", function() {
        hiddenFields('select[id=transp]');
    });

    $(document).submit(function(e) {
        if($('#tipo').val() === 'pj') {
            var atividade = $('#Atividade').val().toLowerCase();

            if(atividade.search(/comércio/) != -1) {
                validaAtividade();
            } else if(atividade.search(/comercio/) != -1) {
                validaAtividade();
            } else if(atividade.search(/fabricante/) != -1) {
                validaAtividade();
            } else if(atividade.search(/fabricacao/) != -1) {
                validaAtividade();
            } else if(atividade.search(/fabricação/) != -1) {
                validaAtividade();
            } else if(atividade.search(/importação/) != -1) {
                validaAtividade();
            } else if(atividade.search(/importacao/) != -1) {
                validaAtividade();
            } else if(atividade.search(/distribuição/) != -1) {
                validaAtividade();
            } else if(atividade.search(/distribuicao/) != -1) {
                validaAtividade();
            }

            if($('#contato').val() == '') {
                alertLatch("O campo contato está vazio. Favor preencher", "var(--cor-warning)");
                $('#contato').focus();
                return false;
            }

            if($('#Email').val() == '') {
                alertLatch("O campo email está vazio ou preenchido incorretamente", "var(--cor-warning)");
                $('#Email').focus();
                return false;
            }

            if($('#telefone').val() == '') {
                alertLatch("O campo telefone está vazio. Favor preencher", "var(--cor-warning)");
                $('#telefone').focus();
                return false;
            }

        } else if($('#tipo').val() === 'pf') {
            if($('#cel').val() == '') {
                alertLatch("Informar o número de celular", "var(--cor-warning)");
                $('#cel').css("background",'#faffbd').focus();
                return false;
            }

            if($('#nascimento').val().length !== 10) {
                $('#nascimento').focus();
                return false;
            }
        }
    });

    //$(".identification").text(identification);

    $('#cep').mask('00000-000');
    $('#cepPJ').mask('00000-000');
    $('#telefonePJ').mask('(00)0000-0000');
    $('#celularPJ').mask('(00)90000-0000');
    $('.loading, #mask_main').hide();

    $("form").show();

    $(".searchCpf").click(function() {
        var cpf = $('form input[name=CPF]').val();

        if( cpf !== "" ) {
            buscaCpf(formAtivo, cpf);
        } else {
            $('form input[name=CPF]').focus();
        }
    });

    $(".searchCnpj").click(function() {
        var cnpj = $('input[name=CNPJ').val();

        if( cnpj !== "" ) {
            buscaCnpj(formAtivo, cnpj);
        } else {
            $('input[name=CNPJ').focus();
        }
    });

    $(".searchCep").click(function() {
        var dom;

        if( formAtivo === "pf" ) {
            dom = $("input#cepBusca");
        } else {
            dom = $("input#cepBuscaPJ");
        }

        if( dom.val() !== "" ) {
            buscaCep(dom, formAtivo);
        } else {
            dom.focus();
        }
    });
    selectForm(formAtivo);
});

function hiddenFields(element) {
    element = $(element);
    var transpId = element.val();/* cnpj */
    var companyId;
    var transpCnpj;
    element.children("option").each(function() {
        if($(this).attr("value") === transpId) {
            companyId = $(this).attr("data-companyId");
            transpCnpj = $(this).attr("data-transpCnpj");
        }
    });
    $('input[type=hidden]').each(function() {
        if($(this).attr('name') === 'IDTransportadora') {
            $(this).val(transpId);
        } else if($(this).attr('name') === 'transpCompanyId') {
            $(this).val(companyId);
        } else if($(this).attr('name') === 'transpCnpj') {
            $(this).val(transpCnpj);
        }
    });
}

/** hidden form */
function selectForm(formActive) {
    if(formActive === 'pf') {
        $('#pf').show();
        $('#pj').hide();
        $('input[name=CPF]').focus();
    } else {
        $('#pf').hide();
        $('#pj').show();
        $('input[name=CNPJ]').focus();
        formAtivo = "pj";
    }
    return formActive;
}

/* funcao validar cpf */
function validCPF(cpf) {
    cpf_ = cpf.replace(/[^0-9]/g,'');
    if( cpf_.length === 11 ) {
        var v = [];

        /*Calcula o primeiro dígito de verificação.*/
        v[0] = 1 * cpf_[0] + 2 * cpf_[1] + 3 * cpf_[2];
        v[0] += 4 * cpf_[3] + 5 * cpf_[4] + 6 * cpf_[5];
        v[0] += 7 * cpf_[6] + 8 * cpf_[7] + 9 * cpf_[8];
        v[0] = v[0] % 11;
        v[0] = v[0] % 10;

        /*Calcula o segundo dígito de verificação.*/
        v[1] = 1 * cpf_[1] + 2 * cpf_[2] + 3 * cpf_[3];
        v[1] += 4 * cpf_[4] + 5 * cpf_[5] + 6 * cpf_[6];
        v[1] += 7 * cpf_[7] + 8 * cpf_[8] + 9 * v[0];
        v[1] = v[1] % 11;
        v[1] = v[1] % 10;

        /*Retorna Verdadeiro se os dígitos de verificação são os esperados.*/
        if ( (v[0] != cpf_[9]) || (v[1] != cpf_[10]) ) {
            $('#cpf').addClass("is-invalid");
            alertLatch("CPF inválido: " + cpf, "var(--cor-warning)");
            $("form input").val("");

            return $("form input#cpf").val("").focus();
        }
    }

    $('#cpf').removeClass("is-invalid");
    $('#cpf').addClass("is-valid");

    return cpf;
}

function limpa_formulário_cep() {
    $("#endereco").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#uf").val("");
    $("#ibge").val("");
}

function validaAtividade() {
    if($('input[name=InscEstadual]').val() == '') {
        alertLatch("Inscrição Estadual está em branco. Favor preencher", "var(--cor-warning)");
        $('input[name=InscEstadual]').focus();
        return false;
    }
}

function buscaCpf(formAtivo, cpf) {
    $(this).css('background','white');
    $('#nome').focus();
    var url = "cadastro/'" + cpf + "'";//"../loadAjax/ajaxCadastro.php";

    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: { cpf: cpf },
        beforeSend: function(){
            $(".loading, #mask_main").show();
        },
        success: function(response){
            var submit = $("form#" + formAtivo).find("[type=submit]");
            $("form#" + formAtivo + " [name=" + i + "]").val();
            if(Object.keys(response).length !== 0) {
                for(var i in response) {
                    $("form#" + formAtivo + " [name=" + i + "]").val(response[i]);
                }
                submit.text("Atualizar");
            } else {
                $("form#" + formAtivo).find("input:not([name=CPF])").val("");
                submit.text("Salvar");
            }
            if(response["IDTransportadora"]){
                $.ajax({
                    url: "transport/id/" + response["IDTransportadora"],
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: response["IDTransportadora"]
                    },
                    success: function(listIds) {
                        $(".preForm select[id=transp]").children("option").each(function() {
                            var value = $(this).val();
                            if(listIds.indexOf(value) !== -1) {
                                $(".preForm select[id=transp]").val(value);
                            }
                            if(listIds.length === 0 && $(this).text() === "SEM FRETE") {
                                $(".preForm select[id=transp]").val(value);
                                $(".preForm select[id=transp]").trigger("change");
                            }
                        });
                    }
                });
            }
            /** defining hidden carrier fields */
            hiddenFields('select[id=transp]');
        }
    }).fail(function(error){
        alertLatch("Nenhum dado encontrado", "var(--cor-warning)");
    }).always(function(){
        $(".loading, #mask_main").hide();
    });
}

function buscaCnpj (formAtivo, cnpj) {
    var data = $("form[id=" + formAtivo).serialize();
    var cnpj = cnpj.replace(/([^\d])+/gim, '');
    var url = "cadastro/" + cnpj;
    if(typeof(page) !== "undefined" && page !== "CLIENTE") {
        url = page.toLowerCase() + "/" + cnpj;
    }

    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: {
            cad: cad,
            cnpj: cnpj
        },
        beforeSend: function() {
            $("form").find("input").not("[name=CNPJ]").val("");
            $(".loading, #mask_main").show();
        },
        success: function(response) {
            console.log(response);
            $("form#" + formAtivo).find("[type=submit]").text(response.buttonText);
            $("form#" + formAtivo + " [name=StatusAtivo]").attr("checked", false);
            if(response !== null) {
                for(var i in response) {
                    if(response[i] !== null) {
                        switch(i) {
                            case "InscEsdatual":
                                i = "InscEstadual";
                                break;
                            case "Cep": case "cep":
                                i = "CEP";
                                break;
                            case "StatusAtivo":
                                console.log(response[i]);
                                $("form#" + formAtivo + " [data-ativo=0]").val(0);
                                $("form#" + formAtivo + " [data-ativo=1]").val(1);
                                $("form#" + formAtivo + " [name=" + i + "][data-ativo=" + response[i] + "]").attr("checked",true);
                            // default:
                            //     i_ = i;
                        }
                    }
                    if(i !== "StatusAtivo") {
                        $("form#" + formAtivo + " [name=" + i + "]").val(response[i]);
                    }
                }
                if(response["IDTransportadora"]){
                    $.ajax({
                        url: "transport/id/" + response["IDTransportadora"],
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: response["IDTransportadora"]
                        },
                        success: function(listIds) {
                            $(".preForm select[id=transp]").children("option").each(function() {
                                var value = $(this).val();
                                if(listIds.indexOf(value) !== -1) {
                                    $(".preForm select[id=transp]").val(value);
                                }
                                if(listIds.length === 0 && $(this).text() === "SEM FRETE") {
                                    $(".preForm select[id=transp]").val(value);
                                    $(".preForm select[id=transp]").trigger("change");
                                }
                            });
                        }
                    });
                }
                /** defining hidden carrier fields */
                hiddenFields('select[id=transp]');
            } else {
                alertLatch("Nenhum dado foi encontrado", "var(--cor-warning)");
                return false;
            }
        }
    }).fail(function(error){
        alertLatch("Whoops! Ocorreu algum erro...", "var(--cor-danger)");
        return false;
    }).always(function(){
        $(".loading, #mask_main").hide();
    });
}

function buscaCep(dom, formAtivo) {
    $(".loading, #mask_main").show();
    var cep = $(dom).val().replace(/\D/g, '');

    if (cep !== "") {
        var validacep = /^[0-9]{8}$/;

        if(validacep.test(cep)) {
            if( formAtivo === "pf") {
                $("#endereco").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");
                $("#cep").val("...");
            } else {
                $("#ruaPJ").val("...");
                $("#complementoPJ").val("...");
                $("#bairroPJ").val("...");
                $("#cidadePJ").val("...");
                $("#ufPJ").val("...");
                $("#cepPJ").val("...");
            }

            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {
                    if( formAtivo === "pf") {
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        $("#cep").val(dados.cep);
                        $("#ibge").val(dados.ibge);
                    } else {
                        $("#ruaPJ").val(dados.logradouro);
                        $("#complementoPJ").val(dados.complemento);
                        $("#bairroPJ").val(dados.bairro);
                        $("#cidadePJ").val(dados.localidade);
                        $("#ufPJ").val(dados.uf);
                        $("#cepPJ").val(dados.cep);
                    }

                    $(".loading, #mask_main").hide();
                } else {
                    limpa_formulário_cep();
                    alertLatch("CEP não encontrado", "var(--cor-warning)");
                    $(".loading, #mask_main").hide();
                }

            });

            if( formAtivo === "pf") {
                $('#numero').focus();
            } else {
                $('#numPJ').focus();
            }

            $(this).css('background','none');

        } else {
            limpa_formulário_cep();
            alertLatch("Formato de CEP inválido", "var(--cor-warning)");
            $(".loading, #mask_main").hide();
        }
    } else {
        limpa_formulário_cep();
    }
}

function saveAjaxData(data, act = "salvar") {
    var origem = (cad === "ACESSO" ? "cad_pessoa" : "cad_cliente");
    IDEmpresa = (typeof(IDEmpresa) === "undefined" ? null : IDEmpresa);
    var url = "cadastro/" + act + "?origem=" + origem + "&act=" + cad + "&IDEmpresa=" + IDEmpresa;
    if(cad !== "CLIENTE") {
        url = cad.toLowerCase() + "/" + act;
    }

    $.ajax( {
        url: url,
        type: "POST",
        data: data,
        dataType: "json",
        cache: false,
        beforeSend: function() {
            $(".loading, #mask_main").show();
        }
    }).done(function( response ) {
        var background = "var(--cor-warning)";
        if(response.indexOf("success") !== -1) {
            background = "var(--cor-success)";
        } else if (response.indexOf("danger") !== -1) {
            background = "var(--cor-danger)";
        }
        alertLatch(response, background);
    }).fail(function( error ) {
        alertLatch("Ops!!! Houve algum erro!", "var(--cor-danger)");
    }).always(function( data ) {
        $(".loading, #mask_main").hide();
    });
}
