function exhibition(element) {
    $(element).on("click", function() {
        var action = $(this).attr("title");
        var login = $(this).closest("tr").find("td:eq(1)").text();
        //var url = "../Modals/login.php?act=edit&login=" + login;
        var url = "edit-login&act=edit&login=" + login;
        if(action === "Edita") {
            $("#exhibition")
                .load(url)
                .on("submit", function(e) {
                    e.preventDefault();
                    var buttonName;
                    var dataSet = $(this).find("form").serializeArray();
                    buttonName = $(this).text();
                    if(buttonName !== "Salvar") {
                        dataSet.push(
                            {
                                name: "act",
                                value: "login"
                            },
                            {
                                name: "action",
                                value: "edit"
                            }
                        );
                        //var link = "../Support/ajaxSave.php";
                        url = "save-login";
                        saveData(url, dataSet);
                    }
                });
        }
        else if(action === "Exclui") {
            var logged = $(".identification").text().split(":")[1].trim().toLowerCase();
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
                        name: "act",
                        value: "login"
                    },
                    {
                        name: "Logon",
                        value: login
                    },
                    {
                        name: "action",
                        value: "delete"
                    }
                ];
                if($(this).val() == 1) {
                    //var link = "../Support/ajaxSave.php";
                    var url = "delete-login";
                    saveData(url, dataSet, "Excluindo");
                    setTimeout(function() {
                        $("#boxe_main .close").trigger("click");
                        window.location.reload();
                    }, setTime);
                }
            });
        }
        else if(action === "Reseta") {
            modal.confirm({
                title: "A senha será excluída",
                message: "A nova senha será cadastrada no próximo login"
            }).on("click", function() {
                if($(this).val() == 1) {
                    //var link = "../Support/ajaxSave.php";
                    var url = "save-login";
                    var data = [
                        {
                            name: "act",
                            value: "login"
                        },
                        {
                            name: "action",
                            value: "reset"
                        },
                        {
                            name: "Logon",
                            value: login
                        }
                    ];
                    if(saveData(url, data)) {
                        modal.hide();
                    }
                }
            });
        }

    });
}
function disabledTableLine(dom) {
    /** highlighting disabled user */
    $(dom).each(function() {
        var that = $(this);
        var disabledItens = $(this).find("td:eq(3)").text();
        if(disabledItens !== "SIM") {
            that.find("td").each(function() {
                if($(this).index() < 4) {
                    var text = $(this).text();
                    $(this)
                        .html("<strike>" + text + "</sctrike>")
                        .css("color","var(--cor-secondary-light)");
                }
            });
        }
    });
}

$(function() {
    if(companyId) {
        disabledTableLine("#exhibition table tbody tr");
    }
    $("select[name=NomeFantasia]").change(function() {
        var companyId = $(this).val();
        //var url = "../web/login&companyId=" + companyId;
        var url = "login&companyId=" + companyId;
        $(location).attr("href", url);
    });
    $(".container .header button").on("click", function() {
        var btnAction = $(this).text();
        var companyId = $("select[name=NomeFantasia]").val();
        //var url = "../Modals/login.php?act=edit";
        var url = "add-login&act=edit";
        if(btnAction === "Adicionar") {
            $("#exhibition")
                .load(url)
                .on("submit", function(e) {
                    e.preventDefault();
                    var dataSet = $(this).find("form").serializeArray();
                    dataSet.push(
                        {
                            name: "act",
                            value: "login"
                        },
                        {
                            name: "action",
                            value: "add"
                        },
                        {
                            name: "IDEmpresa",
                            value: companyId
                        }
                    );
                    //var link = "../Support/ajaxSave.php?act=login";
                    var link = "save-login&act=login";///{" + dataSet + "}";
                    var result = saveData(link, dataSet);
                    if(result) {
                        $("#exhibition form#login-register")
                            .find("button[type=reset]")
                            .trigger("click");
                    }
            });
        }
        else {
            var companyId = $(this).closest(".header").find("select :selected").val();
            //var url = "../Modals/login.php?act=list&companyId=" + companyId;
            var url = "list-login&act=list&companyId=" + companyId;
            $("#exhibition").load(url, function() {
                exhibition("#exhibition table#tabList tbody td");
                disabledTableLine("#exhibition table tbody tr");
            });
            //location.reload();
        }
    });
    exhibition("#exhibition table#tabList tbody td");
});
