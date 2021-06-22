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

$("#topHeader ul li a").on("click", function(e) {
    e.preventDefault();
    var name = $(this).attr("id");
    var li = $(this).closest("li");
    var registerCall = ["cliente","fornecedor","transportadora"];

    $("nav#topHeader ul li").removeClass("active");
    li.addClass("active");
    if(name !== "cadastro" && name !== "gerenciamento") {
        $(".loading, #mask_main").show();
        $(".identification").text(identif(name));

        $(".content").load(name, function() {
            $(".loading, #mask_main").hide();
            if(registerCall.indexOf(name) !== -1) {
                scriptRegister();
            }
            if(name === "login") {
                scriptLogin();
            }
            if(name === "shield") {
                scriptSecurity();
            }
        });
    }
});
$("#topHeader ul li a#home").trigger("click");
