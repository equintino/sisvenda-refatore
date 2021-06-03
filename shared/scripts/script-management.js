/** functions */
function openDoc(nDoc, pedido) {
    var url = "image/" + nDoc;
    var title = "Documento em anexo de número: " + nDoc;
    modal.open({
        title: title,
        content: url
    }).complete({
        buttons: '<button class="button error" id="delete" > Excluir Anexo</button>',
        callback: function() {
            $("#boxe_main button#delete").on("click", function() {
                var message = "Deseja realmente excluir o documento " + nDoc + "?";
                var conf = modal.confirm({
                    title: "Você está prestes a excluir o anexo",
                    message: message
                });
                conf.on("click", function() {
                    if($(this).val() == 1) {
                        alertLatch("<div class='success'>Anexo (" + nDoc + ") escluído com sucesso... Brincadeirinha</div>","var(--cor-success)");
                        modal.close();
                    }
                });
            });
        }
    });
}

function getFormData(form) {
    var form        = $("form#filtroGerVenda");
    var busca       = form.find("input[name=busca]").val();
    var tBusca      = form.find("input[name=tBusca]:checked").val();
    var pg          = form.find("input[name=pg]:checked").val();
    var desativado  = form.find("input[name=desativado]:checked").val();
    var saleman     = form.find("select[name=saleman] :selected").val();//attr("data-id");
    var pago        = form.find("input[name=pago]:checked").val();
    var dtInicio    = form.find("input[name=dtInicio]").val();
    var dtFim       = form.find("input[name=dtFim]").val();
    var situacao    = form.find("select[name=situacao] :selected").val();
    var status      = form.find("select[name=status] :selected").val();
    var activeSale  = form.find("input[name=activeSale]:checked").val();
    var companies   = form.find("select[name=companies] :selected").val();

    var situations = form.find("select[name=situacao]").children("Option");
    var sts = form.find("select[name=status]").children("Option");

    sitList = [];
    stsList = [];
    situations.each(function() {
        sitList.push($(this).attr("value"));
    });
    sts.each(function() {
        stsList.push({
            "value": $(this).attr("value"),
            "name": $(this).text()
        });
    });
    return {
        busca, tBusca, pg, desativado, saleman, pago,dtInicio, dtFim, situacao, status, activeSale, companies,sitList,stsList
    };
}

function hideColumns() {
    $("#hideSelection select[name=colunas] option").remove();
    var options = "";
    var numberColumnsTotal = tabSale.columns().data().length;
    var validateColumn = [ "OBS","Arquivos","Documentos","Produto","Pedido","Empresa" ];
    for(var x = 0; x < numberColumnsTotal; x++) {
        var nameColumn = tabSale.columns(x).header()[0].innerText;
        if(validateColumn.indexOf(nameColumn) === -1) {
            var hide = (tabSale.column(x).visible() ? "" : "- ");
            options += "<option value=" + x + ">" + hide + nameColumn + "</option>";
        }
    }
    $("#hideSelection select[name=colunas]").append(options);
}

function selectOnClick() {
    /** Selection when clicking */
    $("#tabSale tr td").on("click", function() {
        /* Prevent from opening the (detail) */
        if(!$(this).hasClass("details-control")) {
            var tr = $(this).parents("tr");
            $("#tabSale tbody tr").removeClass("selected").find("a").css("color","blue");
            tr.addClass("selected");
            tr.find("a").css("color", "white");
        }
    });
}

/** Extract the value of input */
function bValue(b) {
    var value = "";
    var word = "value=";
    for(i in b) {
        if( i > ( b.indexOf(word) + word.length) ) {
            if(b[i] == '\'') break;
            value += b[i];
        }
    }
    return value;
}

/** View product details */
function productDetail(data) {
    var align;
    var dTab;
    var tGeral = 0;
    var obs = data["OBS"];
    var titles = ["Item","Cód. Produto","Descrição","Un. Medida","Qtd","Valor","Valor Total","Obs"];
    var table = "<table class='tabDetail' cellpadding=5 cellspacing=0 border=1" + " width='30%' ><thead><tr style='background: silver;'>";

    for(var i in titles) {
        align = (i !== '2' ? "style='text-align:center'" : null);
        table += "<th "+ align +" style='padding: 4px'>"+ titles[i]+ "</th>";
    }
    $.ajax({
        url: "../produto",
        type: "POST",
        dataType: "JSON",
        data: data,
        async: false,
        beforeSend: function() {
            $(".loading, #mask_main").show();
        },
        success: function(response) {
            table += "<tr>";
            var passed = 0;
            var rows = response.length;
            var align;
            for(var codeProduct in response) {
                align = "center";
                table += "<tr>";
                if(codeProduct !== "OBS" && codeProduct !== "rows") {
                    for(var nameColumn in response[codeProduct]) {
                        var unit = response[codeProduct]["UniMedida"];
                        var value = response[codeProduct][nameColumn];
                        if(nameColumn === "Quantidade") {
                            var qtd = value;
                            value = unit === "MT" ?
                                parseFloat(value).toFixed(1) : parseInt(value);
                        } else if(nameColumn === "Valor") {
                            var price = value;
                            value = moeda(value);
                            align = "right";
                        } else if(nameColumn === "Descrição") {
                            align = "left";
                        }
                        table += "<td align=" + align + ">" + value + "</td>";
                    }
                    tGeral += (qtd * price);
                    table += "<td align=right>" + moeda(qtd * price) + "</td>";
                    if(passed++ === 0) {
                        table += "<td rowspan='" + rows + "'><textarea cols=60 rows='" + rows + "' name=OBS >" + obs + "</textarea></td></tr>";
                    }
                }
            }
        },
        error: function(error) {

        },
        complete: function() {
            $(".loading, #mask_main").hide();
        }
    });
    table += "</tbody><tfood><tr style='background:#eae9e8'><th colspan=6 style='text-align:right'>Total Geral: </th><th align=right> R$ " + moeda(tGeral) + "</th><th></th></tr></tfood>";
    return table;
}

function footerTotal(api) {
    var columnTotal = api.columns()[0].length;
    var desativado = 0;
    var pago = 0;
    for(var x=0; x < columnTotal; x++) {
        var columnName = api.column(x).header().innerText;
        switch(columnName) {
            case "Valor":
                var total = api
                    .column(x, { page: "current" })
                    .data()
                    .reduce( function (a, b) {
                        return a + valReal(b);
                    }, 0 );
                break;
            case "Custo Venda":
                var totalCusto = api
                    .column(x, { page: "current" })
                    .data()
                    .reduce(function (a, b) {
                        return a + valReal(bValue(b));
                    }, 0);
                break;
            case "Comissão":
                var totalComissao = api
                    .column(x, { page: "current"} )
                    .data()
                    .reduce(function (a, b) {
                        return a + valReal(b);
                    }, 0);
                break;
            case "Créd. Dev.":
                var pageTotalCred = api
                    .column(x, {page: "current"})
                    .data()
                    .reduce(function (a, b) {
                        return a + valReal(b);
                    }, 0);
                break;
            case "Frete":
                var pageTotalFrete = api
                    .column(x, { page: "current" })
                    .data()
                    .reduce(function (a, b) {
                        return a + valReal(b);
                    }, 0);
                break;
            case "Desativado":
                var desativadoLucro = 0;
                var nRow;
                var custoVenda;
                var comissao;
                var selectDesativado = api.column(x, { page: 'current'} ).nodes();
                break;
            case "Pago":
                var selecPago = api.column(x, { page: "current" }).nodes();

                $.each(selecPago, function () {
                    var checked = $(this).find("input").prop("checked");

                    if (checked) {
                        nRow = tabSale.row(this).index();
                        pago += valReal(api.row(nRow).data().Valor);
                    }
                });
        }
    }
    $.each(selectDesativado, function () {
        var checked = $(this).find("input").prop("checked");
        if (checked) {
            nRow = tabSale.row(this).index();
            custoVenda = valReal(bValue(api.row(nRow).data().CustoVenda));
            comissao = valReal(api.row(nRow).data().TabComissao);
            var cred = valReal(api.row(nRow).data().CreditoUtilizado);
            var frete = valReal(api.row(nRow).data().Frete);

            desativado += valReal(api.row(nRow).data().Valor);
            desativadoLucro += (desativado - custoVenda - comissao);
            totalCusto -= custoVenda;
            totalComissao -= comissao;
            pageTotalCred -= cred;
            pageTotalFrete -= frete;
        }
    });

    /* Pago */


    // Update footer
    var qtdOrc = api.rows().data().length;
    var html = "<table id='tabFoot' widht='100%'><tr><td style='border-right: 1px solid white' ><span class='mr-4'>Total de Registro(s) " + qtdOrc + "<span></td><td>Total Valor: " + moeda(total) + "</td><td style='border-right: 1px solid white'><span class='mr-4'>Lucro: " + moeda(total - desativado - (totalCusto + totalComissao)) + "</span></td><td><span class='mr-4'>Custo: " + moeda(totalCusto) + "</span></span>Comissão: " + moeda(totalComissao) + "</span><br><span class=mr-4>Frete: " + moeda(pageTotalFrete) + "</span><span class='mr-4'>Crédito Devolvido: " + moeda(pageTotalCred) + "</span></td><td style='border-left: 1px solid white'>Pago: " + moeda(pago) + "</td><td><span class='mr-4'>Desativado: " + moeda(desativado) + "</span></td><td style='border-left: 1px solid white'>Total Geral: R$ " + moeda(total - desativado) + "</td></tr></table>";
    $("#total").html(html);
}

function loadDataTable() {
    var columns = [
        {
            data: null,
            targets: [ 0 ],
            class: "details-control",
            visible: true,
            orderable: false,
            searchable: false,
            defaultContent: ""
        },
        { data: "Pedido"                },
        { data: "Controle"              },
        { data: "NFNum"                 },
        { data: "NomeCliente"           },
        { data: "CNPJeCPF"              },
        { data: "DataVenda"             },
        { data: "HoraVenda"             },
        { data: "Vendedor"              },
        { data: "Situação"              },
        { data: "DESATIVO"              },
        { data: "PAGO"                  },
        { data: "Valor"                 },
        { data: "Status"                },
        { data: "CustoVenda"            },
        { data: "TabComissao"           },
        { data: "CreditoUtilizado"      },
        { data: "Frete"                 },
        { data: "NUM_RASTREIOCORREIOS"  },
        { data: "ORIGEM"                },
        { data: "IDCliente"             },
        { data: "TipoCliente"           },
        { data: "IDEMPRESA"             },
        {
            data: "OBS",
            visible: false,
            searchable: false,
            orderable: false
        },
        {
            data: "Arquivos",
            visible: true,
            orderable: false
        },
        {
            data: "Documentos",
            visible: true,
            orderable: false
        },
        {
            data: "Produto",
            visible: false
        }
    ];
    tabSale = $("#tabSale").on("xhr.dt", function(e,settings, json, xhr) {

    }).DataTable({
        processing      : true,
        serverSide      : true,
        paging          : true,
        searching       : true,
        ordering        : true,
        colReorder      : {
                fixedColumnsLeft: 2,
                fixedColumnsRight: 5,
                reorderCallback: function() {
                    hideColumns();
                },
                realtime: true
        },
        stateSave       : true,
        info            : true,
        lengthChange    : true,
        aLengthMenu     : [
            [ 25, 50, 100, 200, 300, 400, 500 ],
            [ 25, 50, 100, 200, 300, 400, 500 ]
        ],
        iDisplayLength  : 25,
        scrollCollapse  : true,
        scrollY         : 350,
        scrollX         : true,
        select          : {
            style: 'single'
        },
        ajax             : {
                url      : "../sale",
                enctype  : "multipart/form-data",
                type     : "POST",
                dataType : "JSON",
                data     : getFormData(),
                async    : true,
                beforeSend: function(data) {
                    $("#mask_main").show();
                    // $(".screen, #mask_main").show();
                    // $(".progress-bar").css({
                    //     width: 0 + "%"
                    // }).text(0 + "%");

                    /**
                     * showing
                     */
                    //var tab = $("#tabSale").DataTable();
                    //var pageInfo = tab.page.info();
                    //var showing = parseInt(pageInfo.length);
                    //var currentPage = parseInt(pageInfo.page) + 1;

                    var count = 0;
                    var percent = 0;
                    var countRepeated = 0;
                    var totalRows;
                    var lastPage;
                    var extreRows = null;

                    // var perc = function() {
                    //     setTimeout(function() {
                    //         $.ajax({
                    //             url: "../web/percent.txt",
                    //             type: "POST",
                    //             dataType: "text",
                    //             complete: function(response) {
                    //                 var d = response["responseText"].split(",");
                    //                 totalRows = d[0];
                    //                 count = ( d.length ===  1 ? 0 : d[d.length - 1] );

                    //                 extreRows = totalRows % showing;
                    //                 if(extreRows !== 0) {
                    //                     lastPage = parseInt(totalRows / showing) + 1;
                    //                 } else {
                    //                     lastPage = parseInt(totalRows / showing);
                    //                 }
                    //                 /** is last page */
                    //                 showing = (currentPage === lastPage ? extreRows : showing);
                    //                 percent =  parseInt(count * 100/showing);

                    //                 var percentPlus = (percent === 99 && countRepeated > 2 ? 100 : percent);

                    //                 /** avoid infinite loop */
                    //                 if(typeof(countOld) !== "undefined" && countOld === count) {
                    //                     countRepeated++;
                    //                 } else {
                    //                     countRepeated = 3;
                    //                 }
                    //                 var countOld = count;

                    //                 $(".progress-bar").css({
                    //                     width: percentPlus + "%"
                    //                 }).text(percentPlus + "%");
                    //                 if(percentPlus >= 100 || countRepeated > 30) {
                    //                     clearInterval(interval);
                    //                 }
                    //             }
                    //         });
                    //     }, 900);
                    // };

                    /** loop for progress bar */
                    // interval = setInterval (function() {
                    //         perc();
                    //     }, 50);

                },
                error: function(xhr, ajaxOption, thrownError) {
                    console.log(thrownError);
                    alertLatch("<span class=danger>Servidor demorou a responder, tente novamente</span>", "var(--cor-danger)");
                },
                complete: function(response) {
                    $("#mask_main").hide();
                    selectOnClick();
                    //reorderCol(tabSale);
                    // $("#lendo, .dataTables_processing, div#reading, #mask_main").hide();
                    // $("[name=CustoVenda]").mask("#.#00,00",{ reverse: true });
                }
        },
        // initComplete: function() {
        //     setTimeout(function(){
        //       $('.loading-overlay').remove();
        //     }, 1500);
        // },
        columns: columns,
        order: [[ 1, "desc" ]],
        language: {
                zeroRecords     : CONF_DATATABLE_ZERORECORDS,
                infoEmpty       : CONF_DATATABLE_INFOEMPTY,
                sSearch         : CONF_DATATABLE_SEARCH,
                sProcessing     : CONF_DATATABLE_PROCESSING,
                infoFiltered    : CONF_DATATABLE_INFOFILTERED,
                info            : CONF_DATATABLE_INFO,
                sLengthMenu     : CONF_DATATABLE_SLENGTHMENU,
                paginate        : {'previous': 'Anterior','next': 'Próximo'}
        },
        footerCallback: function ( tfoot,row, data, start, end, display ) {
            footerTotal(tabSale);
        }
    });
    return tabSale;
}

$(document).ready(function() {
    $.ajax({
        url: "../company",
        type: "POST",
        dataType: "JSON",
        success: function(response) {
            for(var i in response) {
                $("select[name=companies]").append("<option value='" + i + "'>"
                    + response[i].NomeFantasia + "</option>");
            }
        }
    });
    $("select[name=companies]").on("change", function() {
        var companyId = $(this).val();
        var data = {
            companyId
        };
        if(companyId !== "") {
            $.ajax({
                url: "../saleman",
                type: "POST",
                dataType: "JSON",
                data: data,
                beforeSend: function() {
                    $("select[name=saleman] option").remove();
                },
                success: function(response) {
                    var el = $("select[name=saleman]");
                    el.attr("disabled", false);
                    el.append("<option value=''></option>");
                    for(var i in response) {
                        el.append("<option value='" + response[i].ID_Vendedor + "'>" + response[i].LogON + "</option>");
                    }
                }
            });
        } else {
            $("select[name=saleman]").val(0).attr("disabled", true);
        }
    });
    $("input[name=pg]").on("change", function() {
        if($("input[name=pg]").prop("checked")) {
            $("input[name=pago]").attr("disabled", false);
        } else {
            $("input[name=pago]").attr("disabled", true);
        }
    });
    $("select[name=status]").on("change", function() {
        var status = $(this).val();
        $("input[name=activeSale]").each(function() {
            if(status === "C" || status === "CO") {
                (
                    $(this).attr("value") == 0 ?
                        $(this).attr("checked",true) : $(this).attr("checked", false)
                );
            } else {
                (
                    $(this).attr("value") == 1 ?
                        $(this).attr("checked", true) : $(this).attr("checked", false)
                );
            }
        });
    });
    $('#hideSelection select[name=colunas]').on('change', function (e) {
        e.preventDefault();
        if ($(this).val() != '') {
            var column = tabSale.column($(this).val());
            column.visible(!column.visible());
        }
        var title = $(this).val();
        $(this).find("option").each(function() {
            if($(this).attr("value") === title) {
                var text = $(this).text();
                if(text.substr(0, 1) !== "-") {
                    $(this).text("- " + text);
                } else {
                    $(this).text(text.substr(2));
                }
            }
        });
        $(this).val('');
    });
    $("form#filtroGerVenda").on("submit", function(e) {
        e.preventDefault();
        tabSale.colReorder.reset();
        tabSale.destroy();
        loadDataTable();
    });
    loadDataTable();
    hideColumns();

    $("#tabSale tbody").on("change", "td input[name=DESATIVO], td input[name=PAGO]", function() {
        footerTotal(tabSale);
    });

    /* Hide and show details */
    // Array to track the ids of the displayed details
    var detailRows = [];
    $('#tabSale tbody').on('click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabSale.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if (row.child.isShown()) {
            tr.removeClass( 'details' );
            row.child.hide();
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        } else {
            tr.addClass( 'details' );
            row.child(productDetail(row.data())).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                 detailRows.push( tr.attr('id') );
            }
        }
    });
});
