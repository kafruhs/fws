$(document).ready(function(){
    var max = $('span#numPages').text();
    var pager = $('#pager');
    pager.spinner({
        max: max,
        min: 1
        //stop: function(e, ui) {
        //    alert(e.which);
        //    spinStop(max)
        //}
    });
    pager.focusout(function(){
        spinStop(max)
    });
});

function spinStop(max) {
    var input = $('input#pager');
    if (input.val() > max) {
        input.val(max);
    }
    if (input.val() < 1 || isNaN(input.val())) {
        input.val(1);
    }
    $('form#tableOperations').submit();
}