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
                    $(location).attr("href","home");
                }
                else if(response === 2) {
                    var link = "source/Support/Ajax/save.php";
                    var login = $("main form [name=login]").val();
                    var url = "source/Modals/token.php?act=token&login=" + login;

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
            $("#boxe_main, #mask_main").hide();
        }
    });
});
