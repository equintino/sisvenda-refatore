$(document).ready(function() {
    $.ajax({
        url: "../company",
        type: "POST",
        dataType: "JSON",
        success: function(response) {
            for(i in response) {
                $("select[name=companies]").append("<option>" + response[i] + "</option>");
            }
        }
    });
});
