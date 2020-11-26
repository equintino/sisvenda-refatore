/** Modal */
(function (root, factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
      // AMD
      define(['jquery'], factory);
    } else if (typeof exports === 'object') {
      // Node, CommonJS-like
      module.exports = factory(require('jquery'));
    } else {
      // Browser globals (root is window)
      root.modal = factory(root.jQuery);
    }
}(this, function init($, undefined) {
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
                that.mask.fadeOut();
            });
        },
        /** @var title, message, content */
        show: function(params) {
            this.close();
            if(params.title && params.title !== null) this.title.html(params.title).show();
            if(params.message && params.message !== null) this.message.html(params.message).show();
            if(params.content && params.content !== null) this.content.load(params.content);
            this.mask.fadeIn();
            this.nameModal.fadeIn().css({
                display: "flex",
                top: 0
            });
            return this;
        },
        hide: function() {
            $("#boxe_main").hide();
        },
        confirm: function(params) {
            this.close();
            this.content.html("<div align='right'><button class='button cancel' value='0'>Cancela</button><button class='button error' style='margin-left: 3px' value='1'>Confirma</button></div>");
            this.show(params);

            return this.content.find("button").on("button click", function() {
                if($(this).val() == 0) {
                    $("#boxe_main .close").trigger("click");
                }
                else {
                    return $(this).val();
                }
            });
        }
    };
    return modal;
}));

/** loading */
var loading = {
    source: "../web/img/loading.png",
    height: "100%",
    width: "100%",
    show: function(params) {
        var text = (params.text ? params.text : null) ;
        var source = (params.source ? params.source : this.source);
        $("#mask_main").css("z-index","3");
        $("section.loading")
            .css({
                display: "flex"
            });
        $(".text-loading").text(text + "...").css("display","flex");
        return this;
    },
    hide: function() {
        $("section.loading, .text-loading").fadeOut();
        $("#mask_main").css("z-index","1");
    }
};

/** alert message */
var alertLatch = function(text, background) {
    var box = $("#alert").html(text).css("display","none");
    var marginRight = box.width() + 40;
    var css = box.css({
                display: "block",
                overflow: "hidden",
                background: background,
                "margin-right": -marginRight
            });
    css.animate({
            "margin-right": "0"
        }, 1000, function() {
            setTimeout(function() {
                $("#alert").animate({
                    "margin-right": -marginRight
                });
            }, 3000);
        });
    $("#alert").on("click", function() {
        css.animate({
                "margin-right": "0"
            }, 1000, function() {
                setTimeout(function() {
                    $("#alert").animate({
                        "margin-right": -marginRight
                    });
                }, 3000);
            });
    });
};

/** save configuration */
var saveForm = function(act, action, connectionName = null, url = "../Suporte/ajaxSave.php") {
    $("#boxe_main").on("submit", function(e) {
        e.preventDefault();
        var success;
        var data = $("#boxe_main form").serialize();
        var top = $("#top").height();
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {
                act: act,
                action: action,
                connectionName: connectionName,
                data: data
            },
            beforeSend: function() {
                loading.show({
                    text: "salvando"
                });
            },
            success: function(response) {
                var background = "var(--cor-warning)";
                if(response.indexOf("success") !== -1) {
                    background = "var(--cor-success)";
                    success = true;
                }
                else {
                    background = "var(--cor-warning)";
                    success = false;
                }
                alertLatch(response, background);
                setTimeout(function() {
                    loading.hide();
                    (success ? window.location.reload(): null);
                }, setTime);
            },
            error: function(error) {
                alertLatch(response, background);
                setTimeout(function() {
                    loading.hide();
                    $("#mask_main").fadeOut();
                }, setTime);
            },
            complete: function() {
                setTimeout(function() {
                    loading.hide();
                }, 500);
            }
        });
        return success;
    });
};

/**
 * Read screen access
 */
var security = function(groupName, url = null ) {
    var resp;
    $.ajax({
        url: url,
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
        if(screens == " *" || screens.indexOf($(this).text()) !== -1) {
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
var getScreenAccess = function(element, check, groupName) {
    var access = "";
    element.each(function() {
        if($(this).find("i").hasClass(check)) {
            access += (access.length === 0 ? $(this).text() : "," + $(this).text());
        }
    });
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

var saveData = function(link, data, msg = "Salvando") {
    var success = false;
    var top = $("#top").height();
    top = (typeof(top) !== "undefined" ? top : 0);
    $.ajax({
        url: link,
        type: "POST",
        dataType: "JSON",
        context: msg,
        async: false,
        data: data,
        beforeSend: function() {
            $("#mask_main").show();
            loading.show({
                text: msg
            });
        },
        success: function(response) {
            var background;
            if(response.indexOf("success") !== -1) {
                background = "var(--cor-success)";
                success = true;
            }
            else if(response.indexOf("danger") !== -1) {
                background = "var(--cor-danger)";
            }
            else {
                background = "var(--cor-warning";
            }
            alertLatch(response, background);
            setTimeout(function() {
                 loading.hide();
                 $("#mask_main").hide();
            }, setTime);
        },
        error: function(error) {
            var top = $("#top").height();
            alertLatch(response, background);
            setTimeout(function() {
                loading.hide();
                $("#mask_main").fadeOut();
            }, setTime);
        },
        complete: function(data) {}
    });
    return success;
};
