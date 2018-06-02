/* 
 * Create By Kimniyom
 * Date 2015-01-09
 */

$(document).ready(function () {
    var width = $(window).width();
    if (width < 1024) {
        $(".breadcrumb").hide();
        $("#head_submenu").css("font-size", "18px");
    } else {
        $(".breadcrumb").show();
        $("#head_submenu").css("font-size", "30px");
    }

    $(window).resize(function () {
        var width = $(window).width();
        if (width < 1024) {
            $(".breadcrumb").hide();
            $("#head_submenu").css("font-size", "18px");
        } else {
            $(".breadcrumb").show();
            $("#head_submenu").css("font-size", "30px");
        }
    });
    
    var move_marquee;
var marquee_status;
var marquee_move;
var marquee_speed;
var marquee_step;
var marquee_direction;
var newLeft;
var obj;

    var divCover_w = $(".containMarquee").width(); // หาความกว้างพื้นที่ส่วนแสดง marquee
    var divMarquee_w = $(".obj_marquee").width(); //หาความกว้างของเนื้อหา marquee
    obj = $(".obj_marquee"); // กำหนดเป็น ตัวแปร jQuery object
    marquee_direction = 1; /* กำหนดการเลื่อนซ้ายขวา 1 = จากขวามาซ้าย 2 = จากซ้ายไปขวา */
    marquee_speed = 30; // กำหนดความเร็วของเวลาในการเคลื่อนที่ ค่ายิ่งมาก จะช้า
    marquee_step = 1; // กำหนดระยะการเคลื่อนที่ ค่ายิ่งมาก จะเร็ว

    obj.css("left", (marquee_direction == 1) ? divCover_w : -divMarquee_w);
    marquee_move = function (obj) {
        marquee_status = setTimeout(function () {
            move_marquee(obj)
        }, marquee_speed);
    }
    move_marquee = function (obj) {
        var condition_mq = (marquee_direction == 2) ? 'newLeft<divCover_w' : 'newLeft>-divMarquee_w';
        var initLeft = (marquee_direction == 1) ? divCover_w : -divMarquee_w;
        newLeft = (marquee_direction == 1)
                ? parseInt(obj.css('left')) - marquee_step
                : parseInt(obj.css('left')) + marquee_step;
        if (eval(condition_mq)) {
            obj.css({
                'left': newLeft + 'px'
            });
        } else {
            obj.css("left", initLeft);
        }
        marquee_move(obj);
    }
    marquee_move(obj);


    $(".containMarquee").mouseover(function () {
        clearTimeout(marquee_status);
    }).mouseout(function () {
        marquee_move(obj);
    });
});




