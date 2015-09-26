/**
 * 
 */
function xuehua() {
    this.init()
}
xuehua.prototype = {
    init: function() {
        this.pullData()
    },
    pullData: function() {
        var c = window.WBPage.PageData.catelist;
        var g = Math.floor(c.length / 9);
        if (g != (c.length / 9) || g == 0) {
            g = g + 1
        }
        var e = "";
        if (g > 1) {
            e = '<div class="list-panel-toolbar">';
            for (var d = 0; d < g; d++) {
                e += '<span class="weiba-banner-toolbar-item ' + (d == 0 ? "selected": "") + '"></span>'
            }
            e += "</div>"
        }
        var k = '<div id="box" class="list-panel-box tpl-catelist"><div class="list-panel-wrap">',
        h = "</div>" + e + "</div>";
        var a = 0;
        var f = "";
        for (var d = 0; d < g; d++) {
            f += '<ul class="list-panel">';
            for (var b = d * 9; b <= d * 9 + 8; b++) {
                if (c[a]) {
                    f += '<li class="item-box"><a href="' + c[a].url + '" class="cate-item"><img class="cate-icon" src="' + c[a].image + '" /><div class="cate-title">' + c[a].cate_name + "</div></a></li>"
                }
                a = a + 1
            }
            f += "</ul>"
        }
        $(k + f + h).appendTo("body").swipe({
            startSlide: 0,
            speed: 400,
            auto: 0,
            continuous: true,
            disableScroll: false,
            stopPropagation: false,
            callback: function(i, j) {
                if (g > 1) {
                    $("#box .weiba-banner-toolbar-item").eq(i).addClass("selected").siblings().removeClass("selected")
                }
            },
            transitionEnd: function(i, j) {}
        });
        if (g <= 1) {
            $("#box").css({
                "padding-bottom": "0px"
            })
        }
    },
    playMusic: function() {
        var a = $("#music-audio");
        if (a) {
            $(".music-begin").on("tap",
            function() {
                if ($(this).hasClass("pause")) {
                    a[0].play();
                    $(this).removeClass("pause")
                } else {
                    a[0].pause();
                    $(this).addClass("pause")
                }
            });
            $("body").one("tap",
            function() {
                a[0].play();
                $(".music-begin").removeClass("pause")
            })
        }
    },
    snow: function() {
        $.fn.snow({
            minSize: 20,
            maxSize: 30,
            newOn: 400
        })
    }
};
$(window).on("rendercomplete",
function() {
    new xuehua()
});