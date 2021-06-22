/** Constantes */
 const CONF_DATATABLE_ZERORECORDS = "Desculpe - Nada encontrado";
 const CONF_DATATABLE_INFOEMPTY =  "Nenhum dado disponível";
 const CONF_DATATABLE_SEARCH =  "Filtrar";
 const CONF_DATATABLE_PROCESSING = "<div class='progress'><div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='background: #003366' ></div></div><span class='fa-blink'>carregando...</span>";
 const CONF_DATATABLE_LOADING = "<div class='lendoDataTable lendo'><img src='../web/img/lendo.gif' alt='lendo' height='180' /></div>";
 const CONF_DATATABLE_INFOFILTERED =  "(filtrado _MAX_ linha(s))";
 const CONF_DATATABLE_INFO =  "Linhas de _START_ a _END_ do total de _TOTAL_ linhas";
 const CONF_DATATABLE_SLENGTHMENU = "Exibindo _MENU_ linhas por página";
 const CONF_DATATABLE_DECIMAL = ",";
 const CONF_DATATABLE_THOUSANDS = ".";

/** Datatable default */
$.extend( true, $.fn.dataTable.defaults, {
    searching: false,
    ordering: false,
    info: false,
    paging: false
});

/** variables */
var setTime = 500;

$(function($) {
    /** menu behavior */
    // $("#topHeader ul li a").each(function() {
    //     if($(this).attr("id") === page) {
    //         $(this).css({
    //             color: "white"
    //         });
    //     }
    // });

    /** authentication */
    $("main form.form-signin").submit(function(e) {
        e.preventDefault();
        $("main button").html("<i class='fa fa-sync-alt schedule'></i>");
        var data = $("form.form-signin").serialize();
        var url = "src/public/main.php";

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(response) {
                if(response === 1) {
                    $(location).attr("href","");
                } else if(response === 2) {
                    var link = "src/Support/Ajax/save.php";
                    var login = $("main form [name=login]").val();
                    var lkToken = "src/Modals/token.php?act=token&login=" + login;

                    $("#boxe_main, #mask_main").show();
                    $("#boxe_main")
                        .load(lkToken, function() {
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
                            } else {
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
                } else {
                    alertLatch(response, "var(--cor-warning)");
                }
            },
            error: function(error) {
                alertLatch(error["responseText"], "var(--cor-danger)");
            },
            complete: function(response) {
                setTimeout(function(){
                    $("main button").text("Entrar");
                }, 1300);
            }
        });
    });
    $(document).on("keyup", function(e) {
        e.preventDefault();
        if(e.keyCode === 27) {
            $("#boxe_main, #mask_main, #div_dialogue").hide();
            $("#mask_main").css("z-index","2");
        }
    });
});
