$(function($) {
    $(".btnAction").click(function() {
        var groupName = $(this).text();
        $(".screen legend span").text("Grupo: " + groupName)
            .css("float","right");

        $(".btnAction").removeClass("active");
        $(this).addClass("active");

        /** Mark accessible screens */
        var url = "load-group&groupName=" + groupName;
        var screens = security(groupName, url);
        if(screens.success) {
            insertCheck(screens.access, $(".screen p"), "fa fa-check", "fa fa-times");
        }
    });

    var change;
    /* change check */
    $(".screen p i").click(function() {
        if(!$(".btnAction").hasClass("active")) return;
        change = changeCheck($(this), "fa fa-check", "fa fa-times");
    });

    $("button.save, button.cancel").on("click", function(e) {
        e.preventDefault();
        var btnName = this["innerText"];
        if(btnName === "Adicionar Grupo") {
            var url = "add-group";
            var formGroup = modal.show({
                title: "Cadastro de Grupo",
                message: null,
                content: url
            });
            $(formGroup.content).on("submit", function(e){
                e.preventDefault();
                var groupName = $("[name=group-name]").val();
                if(groupName === "") return;
                //var link = "../Support/ajaxSave.php";
                var url = "save-group";
                var data = {
                    name: groupName//,
                    //act: "group",
                    //action: "add"
                };
                if(saveData(url, data)) {
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
            //var url = "../Support/ajaxSave.php";
            var url = "delete-group";
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
                        //data.act = "group";
                        //data.action = "delete";
                        saveData(url, data);
                        $(".btnAction.active").remove();
                    }
                }
            });
        }
        else if(btnName === "Gravar") { /** parte ok */
            if(!$(".btnAction").hasClass("active") || typeof(change) === "undefined") return;
            var security = getScreenAccess($(".screen p"), "fa fa-check");
            //var url = "../Support/ajaxSave.php";
            var url = "update-group";
            //security.act = "group";
            //security.action = "edit";

            saveData(url, security);
        }
    });
    $("#mask, .mask").click(function() {
        $(".window, #mask").hide();
        $(".window form").remove();
    });
    $("#lendo, #mask").hide();
});