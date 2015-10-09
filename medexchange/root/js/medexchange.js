/**
 * Created by Alex on 23.06.2015.
 */
function disableInputFields() {
    $("table.medoffer input").each(function () {
        var attr = $(this).attr('name');
        if (attr != 'pzn' && attr != 'offerAmount' && attr != 'rabatt') {
            $(this).attr('readonly', 'readonly');
            $(this).addClass('readonly');
        } else {
            $(this).addClass('filled');
        }
    });
    $("table.medoffer select").each(function(){
        $(this).attr('readonly', 'readonly');
        $(this).addClass('readonly');
    });
}

function autoCompleteForm() {
    var actualDir = getBaseDir();
    var ajaxUrl = actualDir + "/de/ajax.php?controller=medexchange_ajax_autocomplete_pzn_Controller";

    var inputPZN = $("input[name='pzn']");
    inputPZN.autocomplete({
        source: ajaxUrl,
        minLength: 4,
        //select: function( event, ui ) {
        //    //fillRow( event, ui )
        //},
        open: function(event, ui) {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
    disableInputFields();
}

function enableInputFields() {
    $("table.medoffer input").each(function () {
        $(this).removeAttr('readonly');
        $(this).removeClass('readonly');
    });
    $("table.medoffer select").each(function () {
        $(this).removeAttr('readonly');
        $(this).removeClass('readonly');
    });
}

function fillRow(pzn) {
    var actualDir = getBaseDir();
    var ajaxUrl = actualDir + "/de/ajax.php?controller=medexchange_ajax_autocomplete_pzn_Controller&cmd=1";
    return $.getJSON(ajaxUrl, {'pzn':pzn}, function(result) {
        var returnValue = true;
        if (result.length == 0) {
            enableInputFields();
        } else {
            disableInputFields();
        }
        console.log('komisch');
        for (var key in result) {
            if ($("input[name=" + key + "]").length) {
                $("input[name=" + key + "]").val(result[key]);
            } else if ($("select[name=" + key + "]").length) {
                $("select[name=" + key + "] option").each(function()
                {
                    if ($(this).text() === result[key]) {
                        $(this).attr('selected', 'selected');
                    }
                });
            }
        }
    });

    //$("table.medoffer input[name='offerAmount']").removeAttr('disabled');
    //$("table.medoffer input[name='rabatt']").removeAttr('disabled');
}

function orderAmountSpinner() {
    var elementInScope = $(".numeric");
    elementInScope.spinner({
        min: 0,
        step: 1,
        start: 0
    });
}

function calcTotalAmount() {
    var totalAmount = 0;
    $('#orderTable tr').each(function(){
        var completePrice = $(this).children('.completePrice');
        if (completePrice.length) {
            var price = $(this).children('.completePrice').text();
            price = transformCurrency(price);
            totalAmount += price;
        }
    });
    totalAmount = totalAmount.toFixed(2);
    totalAmount = String(totalAmount).replace('.', ',');
    $('div#totalAmount span').text(totalAmount);


}

function transformCurrency(price) {
    var formatedPrice = price.replace(',', '.');
    var priceParts = formatedPrice.split(' ');
    return parseFloat(priceParts[0]);
}

function transformPercent(percent) {
    var percentParts = percent.split(' ');
    return parseFloat(percentParts[0]);
}

function setWarenkorb(element) {
    var table = element.parent('table');
    $('#orderContent').css({display: 'block'});
    $('#orderNoContent').css({display: 'none'});
    $('#totalAmount').css({display: 'inline-block'});
    var trElement = element.parents('.row');
    var lk = parseInt(trElement.attr('id'));
    var name = trElement.children('#name').children('div').text();
    if (name.length >= 20) {
        name = name.substr(0, 20) + '...';
    }
    var percent = trElement.children('#rabatt').children('div').text();
    var price = trElement.children('#price').children('div').text();
    price = transformCurrency(price);
    percent = transformPercent(percent);
    //price = Math.round(price * 100 / 100);
    price = price * (1 - (percent/100));
    price = price.toFixed(2);
    var orderAmount = parseInt(element.val());
    var completePrice = price * orderAmount;
    completePrice = completePrice.toFixed(2);
    completePrice = completePrice.replace('.', ',');
    var trOrderTable = $('#orderTable tr#' + lk);
    if (orderAmount > 0) {
        if (trOrderTable.length) {
            $('#orderTable tr#' + lk + ' input[name="orderAmount[]"]').val(orderAmount);
            $('#orderTable tr#' + lk + ' span').text(orderAmount);
            trOrderTable.children('.completePrice').text(completePrice + ' €');
        } else {
            var newRow = "<tr id='" + lk + "'><td class='name'>" + name + "</td>";
            newRow += "<td class='price'>" + price.replace('.', ',') + " €</td>";
            //newRow += "<td class='rabatt'>" + rabatt + " %</td>";
            newRow += "<td class='orderAmount'>";
            newRow += "<input type='hidden' name='orderAmount[]' value='" + orderAmount + "' size='3' /><span>" + orderAmount + '</span>';
            newRow += "<input type='hidden' name='LK[]' value='" + lk + "' size='3' />";
            newRow += "</td>";
            newRow += "<td class='completePrice'>" + completePrice+ " €</td></tr>";
            $("#orderTable").append(newRow);
        }
    } else {
        trOrderTable.remove();
    }
    calcTotalAmount();
    if (!$('#orderTable tr').length) {
        $('#orderContent').css({display: 'none'});
        $('#orderNoContent').css({display: 'block'});
        $('#totalAmount').css({display: 'none'});
    }
}

function getMaxForSpinner(element) {
    var max = element.parents('.row').children('#offerAmount').children('div').text();
    return max;
}

function validateOrderAmount() {
    var element = $("input[name='orderAmount[]']");
    $(element).keyup(function(event, ui) {
        var max = parseInt(getMaxForSpinner($(this)));
        var tdElement = $(this).parents('td');
        if (tdElement.children('.warning').length) {
            tdElement.children('.warning').remove();
        }
        if (parseInt($(this).val()) >= max) {
            $(this).val(max);
            tdElement.append('<p class="warning">Max. Menge erreicht</p>');
        }
        setWarenkorb($(this));
    })

}

function hideHint(input)
{
    var id = input.attr('name');
    var hintElement = $('div.hint#' + id);
    if (hintElement.length) {
        hintElement.hide();
    }
}

function showHint(input)
{
    var id = input.attr('name');
    var hintElement = $('div.hint#' + id);
    if (hintElement.length) {
        hintElement.show();
    }
}
$(document).ready(function(){
    $('div.hint').each(function(){
        var tdElement = $("input[name='" + $(this).attr('id') + "']").parent();
        var pos = tdElement.position();
        $(this).css({top: pos.top, left: pos.left + tdElement.width() + 25})
    });
    autoCompleteForm();
    validateOrderAmount();
    var pznField = $('input[name=pzn]');
    if (pznField.val() == '') {
        pznField.css({'border-color': "red"});
        disableInputFields();
    } else {
        pznField.css({'border-color': "green"});
        enableInputFields();
    }
    pznField.keyup(function() {
        if ($(this).val() == '') {
            pznField.css({'border-color': "red"});
            disableInputFields();
        } else {
            fillRow($(this).val());
            pznField.css({'border-color': "green"});
        }
    });
    $('ul').click(function(){
        fillRow($('input[name=pzn]').val());
        pznField.css({'border-color': "green"});
    });



    $('table.medoffer input').change(function(){
        if ($(this).val() == '') {
            showHint($(this))
        } else {
            hideHint($(this))
        }
    })
});

