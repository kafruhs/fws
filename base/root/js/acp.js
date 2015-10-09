$(function() {
    //var menu = $( "#leftNavigation" ).menu();
    //$(menu).mouseleave(function () {
    //    menu.menu('collapseAll');
    //});
    //menu.menu("focus", null, $( "#menu-4" ).menu().find( ".ui-menu-item:last" ));
    $('.leftNavigation').accordion({
        heightStyle: "content"
    });
    $( ".leftNavigation" ).accordion( "option", "icons", null )
});