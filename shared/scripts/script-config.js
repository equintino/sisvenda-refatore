$(document).ready(function() {
    /** Edition of the configuration */
    $("#config .buttons .button").on("click", function(e) {
        e.preventDefault();
        var url = "configuracao/salvar";
        if($(this).text() === "Adicionar") {
            var content = "configuracao/cadastro";
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
        connectionName = tr.find("td").eq(1).text();
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
            var url = "configuracao/atualizar";
            title = "Modo de Edição de (" + connectionName + ")";
            message = null;
            content = "configuracao/editar/" + connectionName;
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
                        var link = "configuracao/excluir/" + connectionName;
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
});
