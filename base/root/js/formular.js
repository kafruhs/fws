/**
 * Created by Alex on 09.09.13.
 */

function refresh(href)
{
    location.href = href;
}

function ajaxForm()
{
    var msg = $("#ajaxMsg");
    $(".ajaxForm").validate({
        submitHandler: function(form){
            msg.css({'display':'block', 'border-color': '#787878', 'background-color': 'transparent'});
            $(form).ajaxSubmit({
                success: function(data) {
                    var res = $.parseJSON(data);
                    if (res.code == 1) {
                        location.href = res.href;
                    } else {
                        msg.css({'display':'block', 'border-color': '#ff2707', 'background-color': '#ffd4cf'});
                        msg.html(res.message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('Error ' + xhr.status + ': ' + thrownError);
                }
            });
        }
    });
    return false;

}

function ajaxOnClick(a)
{
    var msg = $("#ajaxMsg");
    var url = a.attr('href');
    request = $.ajax({
        url: url,
        success: function(data){
            msg.html(data);
            var res = $.parseJSON(data);
            if (res.code == 1) {
                location.href = res.href;
            } else {
                msg.attr('class', 'ajaxMsgShow');
                msg.html(res.message);
            }
        }
    });

//    request.done(function(data){
//            msg.html(data);
//        });
}

function date() {
    $('.datePicker').datepicker({
        changeYear: true,
        dateFormat: "dd.mm.yy",
        dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
        dayNamesShort: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
        monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
        monthNamesShort: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        showButtonPanel: true,
        currentText: "Heute",
        closeText: 'Fertig',
        constrainInputType: true,
        firstDay: 1
    });
}

function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return decodeURIComponent(pair[1]);}
    }
    return(false);
}

function ajaxCall(url, postName, postValue) {
    var actualDir = getBaseDir();
    url =  actualDir + "/php/ajax/" + url;
    return $.ajax({
        type: "POST",
        url: url,
        data: postName + "=" + postValue,
        success: function(data) {
            var res = $.parseJSON(data);
            $('#ajaxMsg')
                .attr('class', 'ajaxMsgShow')
                .html(res.message);
        }
    });
}

function getBaseDir() {
    return window.location.pathname.substring(0, window.location.pathname.indexOf('/', 1));
}

function submitForm(a)
{
    var url = a.attr('href');
    a.attr('href', '#');

    var form = $('#inputData');
    form.attr('action', url);
    form.submit();
}


$(document).ready(function(){
    date();
    $(".ajaxOnClick").click(function(){
        ajaxOnClick($(this));
        return false;
    });
    $(".submitButton").mouseover(function(){
        $(".submitButton").css({'box-shadow': 'none', 'font-weight': 'bold'});
    }).mouseout(function(){
        $(".submitButton").css({'box-shadow': '#787878 1px 1px 1px 1px', 'font-weight': 'normal'});
    });
    $(".submitLink").click(function() {
        submitForm($(this));
        return false;
    });
    ajaxForm();

    $('input.notFilled').focusout(function(){
         if ($(this).val() != '') {
             $(this).removeClass('notFilled');
         }
    });
    //orderAmountSpinner();
});

