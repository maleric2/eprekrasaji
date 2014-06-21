$(document).ready(function() {
    $(window).scroll(function() {
        //console.log($(window).scrollTop());
        moveToTop = 0;
        if ($(window).scrollTop() < 8)
            moveToTop += $(window).scrollTop();
        else
            moveToTop = 30;
        $("#sidebar-wrapper").stop().animate({"marginTop": (moveToTop) * (-1) + "px"}, 1);
    });
/* ADMIN SIDEBAR */
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("active");
});
//if($( window ).width()>_RESIDED_WIDTH)

});