function closeAjaxMsg() {
    $('#ajaxMsg').attr('class', 'ajaxMsgHide');
}

$(function(){
    $('#closeAjaxMsg').click(function(){
        closeAjaxMsg();
    });
});