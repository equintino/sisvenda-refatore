<link rel="stylesheet" href="../web/css/style-security.css" />
<script>var identificacao = 'ACESSO ÀS TELAS';</script>
<div class="container">
    <h5 class="mt-4" align="center">SEGURANÇA</h5>
    <div>
        <div class="group">
            <fieldset >
                <legend>Grupos</legend>
                <?php foreach($group()->all() as $group): ?>
                    <p class="btnAction"><?= $group->name ?></p>
                <?php endforeach ?>
            </fieldset>
            <button class="button save" style="float: right">Adicionar Grupo</button>
            <button class="button cancel mr-1" style="float: right; cursor: pointer">Excluir Grupo</button>
        </div>
        <div class="middle">
        </div>
        <div class="screen">
            <fieldset>
                <legend>Telas<span></span></legend>
                <?php foreach($getScreens(__DIR__) as $screen): ?>
                    <p><i class="fa fa-times" style="color: red"></i> <?= $screen ?></p>
                <?php endforeach ?>
            </fieldset>
            <button class="button save" style="float: right">Gravar</button>
        </div>
    </div>
</div><!-- container -->

<!--<div class="window"></div>-->

<script type="text/javascript">

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

var saveData = function(link, data) {
    $.ajax({
        url: link,
        type: "POST",
        dataType: "JSON",
        data: data,
        beforeSend: function() {
            loading.show({
                text: "Salvando"
            });
        },
        success: function(response) {                                
            $("#flashes")
                .text(response)
                .css("background", "var(--cor-warning)")
                .slideDown();
            setTimeout(function() {
                $("#flashes").slideUp();
                loading.hide();
            }, 1000);
        },
        error: function(error) {                                
            $("#flashes")
                .text(error)
                .css("background", "var(--cor-error)")
                .slideDown();
            setTimeout(function() {
                $("#flashes").slideUp();
                loading.hide();
            }, 1000);           
        },
        complete: function() {}
    });
};

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

    $("button.save, button.cancel").click(function() {
        if(!$(".btnAction").hasClass("active") && typeof(change) === "undefined") return;
        var btnName = this["innerText"];
        
        if(btnName === "Adicionar Grupo") {return;
            var html = "<form id='grupo' method='post' action='#'>";
            html += "<label class='mr-2'><h6>Novo Grupo: </h6></label>";
            html += "<input name='nome' type='text' />";
            html += "<button class='save ml-1'>OK</button></form>";

            $(".window").append(html);

            $(".window, #mask").show();
            $(".window input[name=nome]").focus()
                .css("text-transform","capitalize");

            $("body").keyup(function(e) {
                e.preventDefault();
    
                if(e.keyCode === 27) {
                    $(".window, #mask").hide();
                    $(".window form").remove();
                }
            });

            $(".window button").click(function(e) {
                e.preventDefault();

                if($("[name=nome]").val() === '') return;
                var data = $(".window form").serialize();
                var nome = $(".window input").val();                
                var nGrupo =  nome.charAt(0).toUpperCase() + nome.slice(1);

                $.ajax({
                    url: "../paginas/addAjax.php?origem=cadGroup",
                    type: "POST",
                    dataType: "JSON",
                    data: data,
                    beforeSend: function() {
                        $("#lendo, #mask").show();
                    },
                    success: function() {
                        $("#flashes").text("Dados inserido com sucesso!").show()
                            .css({
                                "background":"#fabb05",
                                color: "black"
                            });
                        $("#flashes").delay(1500).hide("slow");
                        $(location).attr("href"
                            ,"../web/index.php?pagina=seguranca");
                    }
                }).always(function() {
                    $(".window, #lendo, #mask").hide();
                });
            });
        } 
        else if(btnName === "Excluir Grupo") {return;
            var data = { "nome": btn };
            if(typeof(btn) == "undefined") {
                return;
            } 
            else {
                var conf = subModalConf("Deseja realmente excluir o grupo " 
                    + btn + "?");
                conf.on("click", function() {
                    conf = $(this).text() === "SIM";

                    if(conf) {
                        $.ajax({
                            url: "../paginas/addAjax.php?origem=cadGroup&act=exclui",
                            type: "POST",
                            dataType: "JSON",
                            data: data,
                            beforeSend: function() {
                                $("#lendo").show();
                            },
                            success: function(response) {
                                $("#flashes").text("Dados inserido com sucesso!").show()
                                    .css({
                                        "background":"#fabb05",
                                        color: "black"
                                    });
                                $("#flashes").delay(1500).hide("slow");
                                $(".btnAction.active").remove();
                            }
                        }).always(function() {
                            $("#lendo").hide();
                        });
                    }
                });
            }
        } 
        else if(btnName === "Gravar") { /** parte ok */
            var security = getScreenAccess($(".screen p"), "fa fa-check");
            security.act = "group";
            console.log(saveData("../Support/ajaxSave.php", security));
        }
    });

    $("#mask, .mask").click(function() {
        $(".window, #mask").hide();
        $(".window form").remove();
    });
    $("#identificacao").text(identificacao);
    $("#lendo, #mask").hide();
});
</script>
