$(document).ready(function(){
_whatToAdd = "#PrekrsiteljNovi";/* id of Select */
_whereToAdd = "#PrekrsiteljiCbox";/* id of Checkbox */
_name = "oib[]";
jQuery(document).on("change", _whatToAdd, function() {
    $(_whatToAdd + " option").each(function() {
        //$('input[type=checkbox]'').each(function() {
        if ($(this).is(':selected')) {
            val = $(this).val();
            text = $(this).text();
            insert = true;
            /* AKO POSTOJI */
            $('input[type=checkbox]').each(function() {
                console.log(text + val);
                if ($(this).val() == val)
                    insert = false;
            });
            if (insert) {
                $(_whereToAdd).append("<div class='checkbox checkbox-block-new'>"
                        + "<label>"
                        + "<input type=checkbox checked value='" + val + "' name=" + _name + ">"
                        + text
                        + "<span class='glyphicon glyphicon-remove pull-right'></span>"
                        + "</label></div>");
            }

        }
        ;
    });
})
jQuery(document).on("click", _whereToAdd + " label span", function() {
    console.log("CLICK")
    label = $(this).parent();
    label.parent().remove();
});


});