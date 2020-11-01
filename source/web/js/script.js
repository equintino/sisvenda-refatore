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
var setTime = 2000;

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
    $(".login form.form-signin").submit(function(e) {
        e.preventDefault();
        $(".login button").html("<i class='fa fa-sync-alt schedule'></i>");
        var data = $("form.form-signin").serialize();
        var url = "source/web/login.php";

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                if(response === 1) {
                    $(location).attr("href","source/web");
                }
                else if(response === 2) {
                    var link = "source/Support/ajaxSave.php";
                    var login = $(".login form [name=login]").val();
                    var url = "source/Modals/login.php?act=token&login=" + login;
                    url = "source/web/token";
                    $("#boxe_main, #mask_main").show();
                    $("#boxe_main")
                        .load(url)
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
                                }
                            );
                            if(dataSet[1]["value"] !== dataSet[2]["value"]) {
                                $("#flashes")
                                    .text("As senhas não conferem")
                                    .css({
                                        background: "var(--cor-warning",
                                        top: 0
                                    })
                                    .slideDown();
                                setTimeout(function() {
                                    $("#flashes").slideUp();
                                }, setTime);
                            }
                            else {
                                if(saveData(link, dataSet, "Salvando")) {
                                    setTimeout(function() {
                                        $("#boxe_main, #mask_main").fadeOut();
                                    }, setTime);
                                }
                            }
                        }).css({
                            top: "25%",
                            "padding": "30px"
                        });
                }
                else {
                    $("#flashes")
                        .text(response)
                        .css({
                            background: "var(--cor-warning)",
                            top: 0
                        })
                        .slideDown();
                    setTimeout(function() {
                        $("#flashes").slideUp();
                    }, setTime);
                }
            },
            error: function(error) {
                $("#flashes")
                    .html(error.responseText)
                    .css({
                        background: "var(--cor-danger)",
                        top: 0
                    })
                    .slideDown();
                setTimeout(function() {
                    $("#flashes").slideUp();
                }, setTime);
            },
            complete: function(response) {
                setTimeout(function(){
                    $(".login button").text("Entrar");
                }, 1300);
            }
        });
    });

    /** Edition of the configuration */
    $("#config .buttons .button").on("click", function(e) {
        e.preventDefault();
        if($(this).text() === "Adicionar") {
            //var content = "../Modals/config.php?act=add";
            var content = "add&act=add";
            modal.show({
                title: "Preencha os dados abaixo:",
                content: content
            });

            saveForm("connection","add");
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
            title = "Modo de Edição de (" + connectionName + ")";
            message = null;
            //content = "../Modals/config.php?connectionName=" + connectionName;
            content = "edit&connectionName=" + connectionName;
            modal.show({
                title: title,
                message: message,
                content: content
            });
            saveForm("connection", "edit", connectionName);
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
                        var link = "../Support/ajaxSave.php";
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

    /** testar rota em js */
    // Adds a route for /items/:item and calls the callback when matched
    // $.router.add('/modals', function(data) {
    //     console.log(data);
    // });
    //$.router.go('sisvenda-refatore/source/web/', 'title');

    // $.router.addErrorHandler(function (url) {
    //     // url is the URL which the router couldn't find a callback for
    //     alert(url);
    //     console.log(url);
    // });

    // $.sammy(function() {

    //     // this.get('#/', function() {
    //     //   $('#main').text('Welcome!');
    //     // });
    //     //console.log(this.get('#/'));
    //     this.get('#/', function() {
    //         alert("oi");
    //     });

    //     this.get('#/', function(context,next) {
    //         //$('body').text('Welcome!');
    //         //console.log(this);
    //         // $.get('/Modals',function(){
    //         //   // save the data somewhere
    //         //   next();
    //         // });
    //     }, function(context,next) {
    //         $.get('/some/other/url',function(){
    //           // save this data too
    //           next();
    //         });
    //     });

    // });
});
