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
    },
    hide: function() {
        $("#boxe_main, #mask_main").hide();
    },
    confirm: function(params) {
        this.close();
        this.content.html("<div align='right'><button class='button cancel' value='0'>Cancela</button><button class='button error' style='margin-left: 3px' value='1'>Confirma</button></div>");
        this.show(params);

        var that = this;
        this.content.find("button").on("button click", function() {
            if($(this).val() == 0) {
                $("#boxe_main .close").trigger("click");
            }
            else {
                return $(this).val();
            }
        });
    }
};

/** loading */
var loading = {
    source: "../web/img/loading.png",
    height: "100%",
    width: "100%",
    show: function(params) {
        var text = (params.text ? params.text : null) ;
        $("body")
            .append("<section id='loading'><img class='schedule ml-3' src='" + this.source + "' alt='loading' height='50' /><p align='center'>" + text + "...</p></section>");
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
var configuration = function(connectionName) {
    $("#boxe_main").on("change", function() {
        var data = $("#boxe_main form#config").serialize();
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
            success: function(response) {
                
            },
            error: function(error) {},
            complete: function() {
                setTimeout(function() {
                    loading.hide();
                }, 500);
            }  
        });      
    });
};

$(function($) {
    /**
     * authentication
     */
    $("form").submit(function(e) {
        e.preventDefault();
        $(".login button").html("<i class='fa fa-sync-alt schedule'></i>");
        var data = $("form").serialize();
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
                else {
                    $(".flash")
                        .text(response)
                        .css("background", "var(--cor-warning)")
                        .slideDown();
                    setTimeout(function() {
                        $(".flash").slideUp();
                    }, 3000);
                }
            },
            error: function(error) {
                $(".flash")
                    .html(error.responseText)
                    .css("background","var(--cor-danger)")
                    .slideDown();
                setTimeout(function() {
                    $(".flash").slideUp();
                }, 4000);
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
    $("tbody .edition, tbody .delete").on("click", function() {
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
            content = "../Modals/configuracao.php?connectionName=" + connectionName;
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
        configuration(connectionName); 
    });  

    $(document).on("keyup", function(e) {
        e.preventDefault();

        if(e.keyCode === 27) {
            $("#boxe_main, #mask_main").hide();
        }
    });
});
