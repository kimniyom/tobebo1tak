//* Author By Kimniyom
//* Email kimniyomclub@gmail.com
//* www.theassembler.net

$(document).ready(function () {
    $("#set_homepage").removeClass('container');
    $("#album-views").removeClass('container');
    $(".set-views-card .detail").css({
        "font-size": "12px"
    });

    //News Detail Config
    $(".box-all").css({
        "max-height": "250px"
    });
    $(".set-views-card .img-news-all").css({
        "max-height": "150px"
    });

    //Album 
    $(".album-all img").css({
        "max-height": "150px"
    });

    $(".album-all").css({
        "font-size": "12px",
        "max-height": "250px"
    });

    var BL = $(".BL").height();
    var BR = $(".BR").height();
    var BX = $(".box_homepage").height();

    if (BX === 0 || (BL < BR)) {
        $(".BR").css({"border-left": "#eeeeee solid 1px"});
        $(".BL").css({"border-right": "none"});
    } else {
        if (BL > BR) {
            $(".BL").css({"border-right": "#eeeeee solid 1px"});
            $(".BR").css({"border-left": "none"});
        }
    }

});

$(document).ready(function () {
    $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
                $(this).toggleClass('open');
            },
            function () {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
                $(this).toggleClass('open');
            }
    );
});


