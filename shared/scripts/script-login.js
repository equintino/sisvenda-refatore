function exhibition(element) {
    $(element).on("click", function() {
        var action = $(this).attr("title");
        var tr = $(this).closest("tr");
        var login = tr.find("td:eq(2)").text();
        var url = "usuario/" + login;
        if(action === "Edita") {
            $("#exhibition")
                .load(url)
                .on("submit", function(e) {
                    e.preventDefault();
                    var buttonName;
                    var dataSet = $(this).find("form").serializeArray();
                    buttonName = $(this).text();
                    if(buttonName !== "Salvar") {
                        url = "usuario/update";
                        saveData(url, dataSet);
                    }
                });
        } else if(action === "Exclui") {
            //var logged = $(".identification").text().split(":")[1].trim().toLowerCase();
            if(logged === login) {
                bootbox.alert({
                    message: "Usuário logado, não é permitido excluí-lo",
                    buttons: {
                        ok: {
                            className: "button info"
                        }
                    }
                });
                return null;
            }
            modal.confirm({
                title: "Você deseja realmente excluir o usuário <span style='color:red; margin-left: 5px'><strong>" + login + "</strong></span>",
                message: " "
            }).on("click", function() {
                var dataSet = [
                    {
                        name: "Logon",
                        value: login
                    }
                ];
                if($(this).val() == 1) {
                    var url = "exclui/" + login;
                    saveData(url, dataSet, "Excluindo");
                    setTimeout(function() {
                        $("#boxe_main .close").trigger("click");
                        tr.remove();
                    }, setTime);
                    modal.hide();
                }
                $("#mask_main").hide();
            });
        } else if(action === "Reseta") {
            modal.confirm({
                title: "A senha será excluída",
                message: "A nova senha será cadastrada no próximo login"
            }).on("click", function() {
                if($(this).val() == 1) {
                    var url = "senha/reseta";
                    var data = [
                        {
                            name: "Logon",
                            value: login
                        }
                    ];
                    if(saveData(url, data)) {}
                    modal.hide();
                }
                $("#mask_main").hide();
            });
        }
    });
}
function disabledTableLine(dom) {
    /** highlighting disabled user */
    $(dom).each(function() {
        var that = $(this);
        var disabledItens = $(this).find("td:eq(4)").text();
        if(disabledItens !== "SIM") {
            that.find("td").each(function() {
                if($(this).index() > 0 && $(this).index() < 5) {
                    var text = $(this).text();
                    $(this)
                        .html("<strike>" + text + "</sctrike>")
                        .css("color","var(--cor-secondary-light)");
                }
            });
        }
    });
}

function scriptLogin() {
    if(typeof(companyId) !== "undefined") {
        disabledTableLine("#exhibition table tbody tr");
    }
    $("select[name=NomeFantasia]").change(function() {
        var companyId = $(this).val();
        var url = "lista/usuarios/empresa/" + companyId;
        if(companyId != "") {
            $("#exhibition").load(url, function() {
                exhibition("#exhibition table#tabList tbody td");
                disabledTableLine("#exhibition table tbody tr");
            });
        } //else {
        //     window.location.reload();
        // }
    });
    $(".header button").on("click", function() {
        var btnAction = $(this).text();
        var companyId = $("select[name=NomeFantasia]").val();
        if(companyId == "") {
            alertLatch("Selecione a EMPRESA", "var(--cor-warning)");
            $(this).closest(".header")
                .find("select")
                .focus();
            return false;
        }
        var url = "usuario/cadastro";
        if(btnAction === "Adicionar") {
            $("#exhibition")
                .load(url)
                .on("submit", function(e) {
                    e.preventDefault();
                    var dataSet = $(this).find("form").serializeArray();
                    dataSet.push(
                        {
                            name: "IDEmpresa",
                            value: companyId
                        }
                    );
                    //var link = "save-login&act=login";
                    var link = "usuario/save";
                    var result = saveData(link, dataSet);
                    if(result) {
                        $("#exhibition form#login-register")
                            .find("button[type=reset]")
                            .trigger("click");
                    }
            });
        } else {
            var url = "lista/usuarios/empresa/" + companyId;
            $("#exhibition").load(url, function() {
                exhibition("#exhibition table#tabList tbody td");
                disabledTableLine("#exhibition table tbody tr");
            });
        }
    });
    exhibition("#exhibition table#tabList tbody td");
}
