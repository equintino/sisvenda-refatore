/** Functions */
function modalClient(companyId, cnpjCpf) {
    if(companyId == "") {
        alertLatch("Nenhuma empresa foi selecionada", "var(--cor-warning)");
        return false;
    }
    $("#boxe_main").load("client", { companyId, cnpjCpf }, function() {
        $(this).on("click", "button", function() {
            let btnName = $(this).text();
            let dataForm = btnAction(btnName);
            if(dataForm) {
                fillData(dataForm);
            }
        });
        $(".loading").hide();
        $("#boxe_main, #mask_main").show();
    });
}

function btnAction(name) {
    switch(name) {
        case "Selecionar":
            let typeForm = ($("#boxe_main #pj").css("display") === "none" ? "#pf" : "#pj");
            if($("#boxe_main [name=CNPJ]").val().length == 0 && $("#boxe_main [name=CPF]").val().length == 0) {
                return alertLatch("Não foi selecionado nenhum cliente", "var(--cor-warning)");
            }
            return $("#boxe_main " + typeForm + " input").serializeArray();
            break;
        case "LIMPA BUSCA":
            $("#boxe_main input").val("");
            break;
    }
}

function fillData(data) {
    for(let x = 0; x < data.length; x++) {
        let name = changeName(data[x].name);
        $("#dClient [name=" + name + "]").val(data[x].value);
    }
    $("#boxe_main, #mask_main").hide();
}

function changeName(name) {
    switch(name) {
        case "Nome": case "RasSocial":
            return "NomeCliente";
            break;
        case "ID_PFISICA": case "ID_PJURIDICA":
            return "IDCliente";
            break;
        case "CPF": case "CNPJ":
            return "CNPJeCPF";
            break;
        default:
            return name;
    }
}

/** script call for budget */
function scriptBudged() {
    $("select[name=company-id]").on("change", function() {
        let dataSet = {
            companyId: $(this).val()
        };
        $.ajax({
            url: "transport",
            type: "POST",
            dataType: "JSON",
            data: dataSet,
            beforeSend: function() {
                $(".loading, #mask_main").show();
                $("select[name=IDTransportadora] option").remove();
            },
            success: function(response) {
                let html = "<option value=''><option>";
                for(let i in response) {
                    html += "<option value='" + response[i].IDTransportadora + "'>" + response[i].RasSocial + "</option>";
                }
                $("select[name=IDTransportadora]").append(html);
            },
            complete: function() {
                $(".loading, #mask_main").hide();
            }
        });
    })
    $("#dClient .cSearch").on("click", function() {
        $(".loading").show();
        let companyId = $("#tabFiltroOrc select[name=company-id]").val();
        let cnpjCpf = $("#dClient input[name=CNPJeCPF]").val();
        if(!modalClient(companyId, cnpjCpf)) {
            $("#tabFiltroOrc select[name=company-id]").css("background", "pink");
            $(".loading").hide();
        }
    });
    $(document).on("keydown", function(e) {
        /** F1 */
        if(e.keyCode === 112) {
            $("#dClient .cSearch").trigger("click");
        }
    });
}
