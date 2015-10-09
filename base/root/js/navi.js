function showSubMenu(obj) {
    var id = obj.attr('id');
    var pos = obj.position();
    id = 'entry' + id.charAt(0).toUpperCase() + id.slice(1);
    $('div.naviEntry').css({display: "none", position: "absolute", top: pos.top - obj.height, left: pos.left});
    $('div#' + id).css({display: "inline-block"});
}

$(function(){
    $('.naviCategory').mouseover(function(){
        $('.naviCategory_hover').each(function(){
            $(this).attr('class', 'naviCategory');
        });
        $(this).attr('class', 'naviCategory_hover');
        showSubMenu($(this));
    });
    $('.mainContent').mouseover(function(){
       $('div.naviEntry').css({display: "none"});
    });
});