/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function submitDeleteForm(id) {
    $(`#form-del-${id}`).submit();
}

$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert")
            .fadeTo(500, 0)
            .slideUp(500, function () {
                $(this).remove();
            });
    }, 4000);

    $(`.datatable-enable`).DataTable();
    $('tr.row-template').find('input').prop('disabled', true);
    $('tr.row-template').find('select').prop('disabled', true);

    $("table").on("click", "[data-action=add-new-row]", function () {
        var template = $('tr.row-template');
        var newRow = template.clone();
        newRow.removeClass('row-template');
        newRow.appendTo(template.parent());
        newRow.removeClass('row-template');
        newRow.find('input').prop('disabled', false);
        newRow.find('select').prop('disabled', false);
    });

    $("table").on("click", "[data-action=remove-row]", function () {
        $(this).closest("tr").remove();
    });

    $("input.adjustment-aspect").keyup(function () {
        var value = parseInt($("input.adjustment-aspect[name=value]").val());
        var time = parseInt($("input.adjustment-aspect[name=time]").val());
        var total = value/time;
        $('#total-adjustment').val(total);
    })


    
});
