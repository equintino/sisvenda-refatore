/**
 * Datatable default
 */
$.extend( true, $.fn.dataTable.defaults, {
    searching: false,
    ordering: false,
    info: false,
    paging: false
});

/**
 * variables
 */
var setTime = 500;

$(function($) {
    /** menu behavior */
    $("#topHeader ul li a").each(function() {
        if($(this).attr("id") === page) {
            $(this).css({
                color: "white"
            });
        }
    });

    /** authentication */
    $("main form.form-signin").submit(function(e) {
        e.preventDefault();
        $("main button").html("<i class='fa fa-sync-alt schedule'></i>");
        var data = $("form.form-signin").serialize();
        var url = "source/public/main.php";

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                if(response === 1) {
                    $(location).attr("href","");
                }
                else if(response === 2) {
                    var link = "source/Support/ajaxSave.php";
                    var login = $("main form [name=login]").val();
                    var url = "source/Modals/login.php?act=token&login=" + login;
                    $("#boxe_main, #mask_main").show();
                    $("#boxe_main")
                        .load(url, function() {
                            $("#form-token").find("[name=Senha]").focus();
                        })
                        .on("submit", function(e) {
                            e.preventDefault();
                            var dataSet = $("form#form-token").serializeArray();
                            dataSet.push(
                                {
                                    name: "act",
                                    value: "login"
                                },
                                {
                                    name: "action",
                                    value: "change"
                                },
                                {
                                    name: "Logon",
                                    value: login
                                }
                            );
                            if(dataSet[0]["value"] !== dataSet[1]["value"]) {
                                alertLatch("As senhas não conferem", "var(--cor-warning)");
                            }
                            else {
                                if(saveData(link, dataSet, "Salvando")) {
                                    setTimeout(function() {
                                        $("#boxe_main, #mask_main").fadeOut();
                                    }, setTime);
                                }
                            }
                        }).css({
                            top: "20%",
                            "padding": "30px"
                        });
                }
                else {
                    alertLatch(response, "var(--cor-warning)");
                }
            },
            error: function(error) {
                alertLatch("Ops! Algo deu errado", "var(--cor-danger)");
            },
            complete: function(response) {
                setTimeout(function(){
                    $("main button").text("Entrar");
                }, 1300);
            }
        });
    });

    /** Edition of the configuration */
    $("#config .buttons .button").on("click", function(e) {
        e.preventDefault();
        var url = "save-config";
        if($(this).text() === "Adicionar") {
            var content = "add-config&act=add";
            modal.show({
                title: "Preencha os dados abaixo:",
                content: content
            });

            saveForm("connection","add", "null", url);
        }
    });
    $("table#tabConf tbody .edition, table#tabConf tbody .delete").on("click", function() {
        var connectionName;
        var title;
        var content;
        var tr = $(this).closest("tr");
        connectionName = tr.find("td").eq(0).text();
        if(connectionName.indexOf("*") !== -1) {
            bootbox.alert({
                message: "ESTA CONEXÃO ESTÁ ATIVA: <b>(" + connectionName + ")</b>",
                buttons: {
                    ok: {
                        className: "btn-sm button info"
                    }
                }
            });
            return false;
        }

        if($(this).hasClass("edition")) {
            var url = "update-config";
            title = "Modo de Edição de (" + connectionName + ")";
            message = null;
            content = "edit-config&connectionName=" + connectionName;
            modal.show({
                title: title,
                message: message,
                content: content
            });
            saveForm("connection", "edit", connectionName, url);
        }
        else if($(this).hasClass("delete")) {
            title = "Modo de Exclusão de (" + connectionName + ")";
            message = "VOCÊ ESTÁ PRESTE A EXCLUIR A CONFIGURAÇÃO: <b style='color: red; margin-left: 5px'>(" + connectionName + ")</b>";
            bootbox.confirm({
                message: message,
                buttons: {
                    confirm: {
                        label: "Excluir",
                        className: "button error"
                    },
                    cancel: {
                        label: "Cancelar",
                        className: "button cancel"
                    }
                },
                callback: function(result){
                    if(result) {
                        //var link = "../Support/Save.php";
                        var link = "delete-config";
                        var data = {
                            connectionName: connectionName,
                            act: "connection",
                            action: "delete"
                        };
                        if(saveData(link, data, "Excluindo")) {
                            setTimeout(function() {
                                window.location.reload();
                            }, setTime);
                        }
                    }
                }
            });
        }
        else {
            return false;
        }
    });
    $(document).on("keyup", function(e) {
        e.preventDefault();
        if(e.keyCode === 27) {
            $("#boxe_main, #mask_main").hide();
        }
    });
});
