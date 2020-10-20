$(document).ready(function() {
    if(companyId) {
        $("#exhibition table tbody tr").each(function() {
            var that = $(this);
            if($(this).find("td:eq(3)").text() !== "SIM") {
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
    $("select[name=NomeFantasia]").change(function() {
        var companyId = $(this).val();    
        $(location).attr("href", "../web/index.php?pagina=login&companyId=" + companyId);
    });
    $(".container .header button").on("click", function() {
        var btnAction = $(this).text();
        var companyId = $("select[name=NomeFantasia]").val();
        if(btnAction === "Adicionar") {
            $("#exhibition")
                .load("../Modals/login.php?act=edit")
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
                    var link = "../Support/ajaxSave.php?act=login";
                    var result = saveData(link, dataSet);
                    if(result) {
                        $("#exhibition form#login-register")
                            .find("button[type=reset]")
                            .trigger("click");
                    }
            });

        }
        else {
            location.reload();
        }
    });
    $("#exhibition table#tabList tbody td").on("click", function() {
        var action = $(this).attr("title");
        var login = $(this).closest("tr").find("td:eq(1)").text();
        if(action === "Edita") {
            $("#exhibition")
                .load("../Modals/login.php?act=edit&login=" + login)
                .on("submit", function(e) {
                    e.preventDefault();
                    var buttonName;
                    var dataSet = $(this).find("form").serializeArray();
                    $(this).find("button").on("click", function() {
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
                            var link = "../Support/ajaxSave.php";
                            saveData(link, dataSet);
                        }
                    });
            });
        }
        else if(action === "Exclui") {
            var conf = modal.confirm({
                title: "Você deseja realmente excluir o usuário <span style='color:red; margin-left: 5px'><strong>" + login + "</strong></span>"

            });
            conf.on("click", function() {
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
                    var link = "../Support/ajaxSave.php";
                    saveData(link, dataSet, "Excluindo");
                    setTimeout(function() {
                        $("#boxe_main .close").trigger("click");
                    }, setTime);
                }
            });
        }
        else if(action === "Reseta") {
            var link = "../Support/ajaxSave.php";
            var data = [
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
                    value: "reset"
                }
            ];
            saveData(link, data);
        }
    });
});
