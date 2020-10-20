/**
 * Datatable default
 */
$.extend( true, $.fn.dataTable.defaults, {
    searching: false,
    ordering: false,
    info: false,
    paging: false
});

/** Modal */
var modal = {
    nameModal: $("#boxe_main"),
    mask: $("#mask_main"),
    title: $("#boxe_main #title"),
    message: $("#boxe_main #message"),
    content: $("#boxe_main #content"),
    close: function() {
        var that = this;
        $("#boxe_main .close, #mask_main").on("click", function() {
            that.nameModal.hide();
            that.title.hide();
            that.message.hide();
            that.mask.hide();
            window.location.reload();
        });
    },
    /** @var title, message, content */
    show: function(params) {
        this.close();
        if(params.title && params.title !== null) this.title.html(params.title).show();
        if(params.message && params.message !== null) this.message.html(params.message).show();
        if(params.content && params.content !== null) this.content.load(params.content);
        this.mask.show();
        this.nameModal.show();
        return this;
    },
    hide: function() {
        $("#boxe_main, #mask_main").hide();
    },
    confirm: function(params) {
        this.close();
        this.content.html("<div align='right'><button class='button cancel' value='0'>Cancela</button><button class='button error' style='margin-left: 3px' value='1'>Confirma</button></div>");
        this.show(params);

        var that = this;
        return this.content.find("button").on("button click", function() {
            if($(this).val() == 0) {
                $("#boxe_main .close").trigger("click");
            }
            else {
                return $(this).val();
            }
        });
    },
    on: function() {
        return this;
    }
};

/** loading */
var loading = {
    source: "../web/img/loading.png",
    height: "100%",
    width: "100%",
    show: function(params) {
        var text = (params.text ? params.text : null) ;
        var source = (params.source ? params.source : this.source);
        $("body")
            .append("<section id='loading'><img class='schedule ml-3' src='" + source + "' alt='loading' height='50' /><p align='center'>" + text + "...</p></section>");
        $("section#loading").css({
                position: "fixed",
                top: "25%",
                left: "45%",
                "z-index": "9"
            });
        $("section#loading > p").css({
            position: "relative",
            left: "-2px",
            "letter-spacing": ".1rem",
            color: "var(--cor-primary)",
            "font-size": "1.2rem",
            "text-shadow": "1px 1px 1px white"
        });
        $("#mask_main").css("z-index","3");
    },
    hide: function() {
        $("body section#loading").remove();
        $("#mask_main").css("z-index","1");
    }
};

/** save configuration */
var saveForm = function(connectionName = null) {
    $("#boxe_main").on("submit", function(e) {
        e.preventDefault();
        var data = $("#boxe_main form").serialize();
        $.ajax({
            url: "../Support/ajaxSave.php",
            type: "POST",
            dataType: "JSON",
            data: {
                act: "connection",
                connectionName: connectionName,
                data: data
            },
            beforeSend: function() {
                loading.show({
                    text: "salvando"
                });
            },
            success: function(response) {},
            error: function(error) {},
            complete: function() {
                setTimeout(function() {
                    loading.hide();
                }, 500);
            }  
        });      
    });
};

/**
 * Read screen access
 */
var security = function(groupName) {
    var resp;
    $.ajax({
        url: "../Support/ajaxLoad.php",
        type: "POST",
        dataType: "JSON",
        data: { groupName: groupName },
        async: false,
        success: function(response) {
            response.success = true;
            resp = response;
        },
        error: function(error) {
            error.seccces = false;
            resp = error;
        }
    });
    return resp;
};

/**
* @params array screens(access), element, icon One, icon two
*/
var insertCheck = function(screens, element, optionGreen, optionRed) {
    element.find("i").removeClass();
    element.each(function() {           
        if(screens.indexOf($(this).text()) !== -1) {
            $(this).find("i").addClass(optionGreen)
                .css("color","green");
        } 
        else {
            $(this).find("i").addClass(optionRed)
                .css("color","red");
        }
    });
};

/** @return object */
var getScreenAccess = function(element, check) {
    var access = []; 
    element.each(function() {
        if($(this).find("i").hasClass(check)) {
            access.push($(this).text());
        }
    });
    var groupName = element.parent().find("span").text().replace("Grupo: ","");
    var security = {
        access: access,
        name: groupName
    }; 
    return security;
};

/** 
* @return bool
* @params element, icon One, icon Two  
*/
var changeCheck = function(element, optionGreen, optionRed) {
    var currentOption = element.attr("class");
    element.removeClass();
    if(currentOption === optionRed) {
        element.addClass(optionGreen)
            .css("color","green");
    } 
    else {
        element.addClass(optionRed)
            .css("color","red");                
    }
    return true;
};

var saveData = function(link, data, msg = "Salvando", img = null) {
    var success = false;
    $.ajax({
        url: link,
        type: "POST",
        dataType: "JSON",
        context: msg,
        async: false,
        data: data,
        beforeSend: function() {
            loading.show({
                source: img,
                text: msg
            });
        },
        success: function(response) {
            var background = "var(--cor-warning)";
            if(response.indexOf("success") !== -1) {
                background = "var(--cor-success)";
                success = true;
            }
            else {
                success = false;
            }           
            $("#flashes")
                .html(response)
                .css("background", background)
                .slideDown();
            setTimeout(function() {
                $("#flashes").slideUp();
                loading.hide();
            }, setTime);
        },
        error: function(error) {                             
            $("#flashes")
                .html(error)
                .css("background", "var(--cor-error)")
                .slideDown();
            setTimeout(function() {
                $("#flashes").slideUp();
                loading.hide();
            }, setTime);   
        },
        complete: function(data) {}
    });
    return success;
};

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
                    $(location).attr("href","source/web/index.php?pagina=home");
                }
                else if(response === 2) {
                    var link = "source/Support/ajaxSave.php";
                    var login = $(".login form [name=login]").val();
                    $("#boxe_main, #mask_main").show();
                    $("#boxe_main")
                        .load("source/Modals/login.php?act=token&login=" + login)
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
                                $(".flash")
                                    .text("As senhas não conferem")
                                    .css("background", "var(--cor-warning")
                                    .slideDown();
                                setTimeout(function() {
                                    $(".flash").slideUp();
                                }, setTime);
                            }
                            else {
                                img = "source/web/img/loading.png";
                                if(saveData(link, dataSet, "Salvando", img)) {
                                    $(".flash")
                                        .text("A senha foi salva com sucesso")
                                        .css("background", "var(--cor-success")
                                        .slideDown();
                                    setTimeout(function() {
                                        $(".flash").slideUp();
                                        $("#boxe_main, #mask_main").hide();
                                    }, setTime);
                                }
                            }
                        });
                    /*modal.show({
                        title: "Cadastre uma nova senha",
                        message: "teste",
                        content: "source/Modals/login.php"
                    });*/
                }
                else {
                    $(".flash")
                        .text(response)
                        .css("background", "var(--cor-warning)")
                        .slideDown();
                    setTimeout(function() {
                        $(".flash").slideUp();
                    }, setTime);
                }
            },
            error: function(error) {
                $(".flash")
                    .html(error.responseText)
                    .css("background","var(--cor-danger)")
                    .slideDown();
                setTimeout(function() {
                    $(".flash").slideUp();
                }, setTime);
            },
            complete: function(response) {
                setTimeout(function(){
                    $(".login button").text("Entrar");
                }, 1300);
            }
        });
    });

    /**
     * Edition of the configuration
     */
    $("#config .buttons .button").on("click", function(e) {
        e.preventDefault();
        if($(this).text() === "Adicionar") {
            var content = "../Modals/config.php?act=add";
            modal.show({
                title: "Preencha os dados abaixo:",
                content: content
            });
            saveForm();
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
            content = "../Modals/config.php?connectionName=" + connectionName;
            modal.show({
                title: title,
                message: message,
                content: content
            });
        }
        else if($(this).hasClass("delete")) {
            title = "Modo de Exclusão de (" + connectionName + ")";
            message = "VOCÊ ESTÁ PRESTE A EXCLUIR A CONFIGURAÇÃO: <b>(" + connectionName + ")</b>";
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
                        $.ajax({
                            url: "../Support/ajaxSave.php",
                            type: "POST",
                            dataType: "JSON",
                            data: { 
                                connectionName: connectionName,
                                act: "delete"
                            },
                            bofereSend: function() {
                                loading.show({
                                    text: "excluindo"
                                });
                            },
                            success: function(response) {
                                window.location.reload();
                            },
                            error: function(error) {},
                            complete: function() {
                                loading.hide();
                            }  
                        });
                    }
                }
            });
        }
        else {
            return false;
        }
        saveForm(connectionName); 
    });  
    $(document).on("keyup", function(e) {
        e.preventDefault();
        if(e.keyCode === 27) {
            $("#boxe_main, #mask_main").hide();
        }
    });
});
