function identif(page) {
    if(page === "home")return null;
    switch(page) {
        case "login":
            return "GERENCIAMENTO DE LOGINS";
        case "shield":
            return "TELAS DE ACESSO";
        case "config":
            return "CONFIGURAÇÃO DO ACESSO AO BANCO DE DADOS";
        default:
            return "CADASTRO DE " + page.toUpperCase();
    }
}

function callScript(name) {
    var registerCall = ["cliente","fornecedor","transportadora"];
    if(registerCall.indexOf(name) !== -1) {
        scriptRegister();
    }
    switch(name) {
        case "login":
            scriptLogin();
            break;
        case "shield":
            scriptSecurity();
            break;
        case "config":
            scriptConfig();
    }
}

$("#topHeader ul li a").on("click", function(e) {
    e.preventDefault();
    var name = $(this).attr("id");
    var li = $(this).closest("li");

    $("nav#topHeader ul li").removeClass("active");
    li.addClass("active");
    if(name !== "cadastro" && name !== "gerenciamento") {
        $(".loading, #mask_main").show();
        $(".identification").text(identif(name));

        $(".content").load(name, function() {
            callScript(name);
            $(".loading, #mask_main").hide();
        });
    }
});
$("#topHeader ul li a#home").trigger("click");
