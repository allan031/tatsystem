$(function(){
    $('#btn-menu').click(function(e){
        e.preventDefault();
        $('#menu-list').toggleClass('xs:hidden sm:hidden');
    });
});