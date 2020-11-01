$(function($) {
    $(".btnAction").click(function() {
        var groupName = $(this).text();
        $(".screen legend span").text("Grupo: " + groupName)
            .css("float","right");

        $(".btnAction").removeClass("active");
        $(this).addClass("active");

        var screens = security(groupName);
        if(screens.success) {
            insertCheck(screens.access, $(".screen p"), "fa fa-check", "fa fa-times");
        }
    });

    var change;
    /* marca e desmarca telas */
    $(".screen p i").click(function() {
        if(!$(".btnAction").hasClass("active")) return;
        change = changeCheck($(this), "fa fa-check", "fa fa-times");
    });

    $("button.save, button.cancel").on("click", function(e) {
        e.preventDefault();
        var btnName = this["innerText"];
        if(btnName === "Adicionar Grupo") {
            var formGroup = modal.show({
                title: "Cadastro de Grupo",
                message: null,
                content: "../Modals/grupo.php"
            });
            $(formGroup.content).on("submit", function(e){
                e.preventDefault();
                var groupName = $("[name=group-name]").val();
                if(groupName === "") return;
                var link = "../Support/ajaxSave.php";
                var data = {
                    name: groupName,
                    act: "group",
                    action: "add"
                };
                if(saveData(link, data)) {
                    setTimeout(function() {
                        $("#mask_main").trigger("click");
                        window.location.reload();
                    }, 1000);
                }
            });
        }
        else if(btnName === "Excluir Grupo") {
            if(!$(".btnAction").hasClass("active")) return;
            var groupName = $(".group .active").text();
            var conf = bootbox.confirm({
                message: "Deseja realmente excluir o grupo <span style='color:red; font-size: 1.1rem; margin-left: 5px'>" + groupName + "</span>",
                buttons: {
                    confirm: {
                        label: "Confirma",
                        className: "button error"
                    },
                    cancel: {
                        label: "Cancela",
                        className: "button cancel"
                    }
                },
                callback: function(result) {
                    if(result) {
                        data = {};
                        data.name = groupName;
                        data.act = "group";
                        data.action = "delete";
                        saveData("../Support/ajaxSave.php", data);
                        $(".btnAction.active").remove();
                    }
                }
            });
        }
        else if(btnName === "Gravar") { /** parte ok */
            if(!$(".btnAction").hasClass("active") || typeof(change) === "undefined") return;
            var security = getScreenAccess($(".screen p"), "fa fa-check");
            security.act = "group";
            security.action = "edit";
            saveData("../Support/ajaxSave.php", security);
        }
    });
    $("#mask, .mask").click(function() {
        $(".window, #mask").hide();
        $(".window form").remove();
    });
    $("#lendo, #mask").hide();
});