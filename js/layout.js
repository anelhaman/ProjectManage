$(document).ready(function(){

    // NAVIGATION EVENT
    $('#btn-more-menu').click(function(){
        $('#more-menu').fadeIn(100);
        $('#filter').fadeIn(100);
    });

    $('#filter').click(function(){
        $(this).fadeOut(100);
        $('#more-menu').fadeOut(100);
    });
});