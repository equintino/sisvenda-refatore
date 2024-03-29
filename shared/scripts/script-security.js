/** functions */
function checkGroup() {
    var groupName = $(".group fieldset p.active").text();
    $(".screen legend span").text("Grupo: " + groupName).css("float","right");

    /** Mark accessible screens */
    var url = "grupo/" + groupName;
    var screens = security(groupName, url);
    if(screens.success) {
        insertCheck(screens.access, $(".screen span"), "fa fa-check", "fa fa-times");
    }
}

function scriptSecurity() {
    //(typeof(page) !== "undefined" && page === "shield" ? checkGroup() : null);
    checkGroup();
    $(".btnAction").on("click", function() {
        var groupName = $(this).text();
        $(".screen legend span").text("Grupo: " + groupName).css("float","right");

        $(".btnAction").removeClass("active");
        $(this).addClass("active");

        /** Mark accessible screens */
        var url = "grupo/" + groupName;
        var screens = security(groupName, url);
        if(screens.success) {
            insertCheck(screens.access, $(".screen span"), "fa fa-check", "fa fa-times");
        }
    });

    var change;
    /* change check */
    $(".screen span").on("click", function() {
        if(!$(".btnAction").hasClass("active")) return;
        change = changeCheck($(this).find("i"), "fa fa-check", "fa fa-times");
    });

    $("button.save, button.cancel").on("click", function(e) {
        e.preventDefault();
        var btnName = this["innerText"];
        if(btnName === "Adicionar Grupo") {
            var url = "grupo/cadastro";
            var formGroup = modal.show({
                title: "Cadastro de Grupo",
                message: null,
                content: url
            });
            $(formGroup.content).on("submit", function(e){
                e.preventDefault();
                var groupName = $("[name=group-name]").val();
                if(groupName === "") return;
                var url = "grupo/save";
                var data = {
                    name: groupName
                };
                if(saveData(url, data)) {
                    $("#boxe_main").hide();
                    $(".content").load("shield", function() {
                        scriptSecurity();
                    });
                }
            });
        } else if(btnName === "Excluir Grupo") {
            if(!$(".btnAction").hasClass("active")) return;
            var groupName = $(".group .active").text();
            var url = "grupo/exclui/" + groupName;
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
                        saveData(url, data);
                        $(".btnAction.active").remove();
                    }
                }
            });
        } else if(btnName === "Gravar") { /** parte ok */
            if(!$(".btnAction").hasClass("active") || typeof(change) === "undefined") return;
            var groupName = $(".group .active").text();
            var security = getScreenAccess($(".screen span"), "fa fa-check", groupName);
            var url = "grupo/update";
            saveData(url, security);
        }
    });
    $("#mask, .mask").on("click", function() {
        $(".window, #mask").hide();
        $(".window form").remove();
    });
    $("#lendo, #mask").hide();
}
