$("#topHeader ul li a").on("click", function(e) {
    e.preventDefault();
    var name = $(this).attr("id");
    var li = $(this).closest("li");

    $("nav#topHeader ul li").removeClass("active");
    li.addClass("active");
    if(name !== "cadastro" && name !== "gerenciamento") {
        var identification = "CADASTRO DE " + name.toUpperCase();
        if(name === "login") {
            identification = "GERENCIAMENTO DE LOGINS";
        } else if(name === "shield") {
            identification = "TELAS DE ACESSO";
        } else if(name === "config") {
            identification = "CONFIGURAÇÃO DO ACESSO AO BANCO DE DADOS";
        }
        if(name !== "home") {
            $(".identification").text(identification);
        }
        $(".content").load(name);
    }
});
$("#topHeader ul li a#home").trigger("click");
