$(document).ready(function () {
    $('.flickr-photos-list').jflickrfeed({
        limit: 9,
        qstrings: {
            id: '71865026@N00'
        },
        itemTemplate: '<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
    });
    $().UItoTop({ easingType: 'easeOutQuart' });
    // PrettyPhoto
    $("a[rel^='prettyPhoto']").prettyPhoto({
        theme: 'light_square',
        social_tools: false
    });
    jQuery('.search-toggle').click(function () {
        jQuery('#header-search-box').slideToggle("fast");
    });
    jQuery('#header-search-box .close').click(function () {
        jQuery('#header-search-box').slideUp("fast");
    });

    $(".cnbox").each(function () {
        var nheight = $(this).find(".nbox").height();
        $(this).find(".cbox").css("height", nheight + 50);
    });
    $(".sbox").hover(function () {
        $(this).find(".sbox-icon").addClass('animated pulse').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(this).removeClass('animated pulse');
        });
    });
    $(".skin-chooser-toggle").click(function () {
        $(".skin-chooser-wrap").toggleClass("show");
    });
    $(".color-skin").click(function () {
        var cls = this.id;
        $(".color-skin").removeClass("active");
        $(this).addClass("active");
        $("body").removeClass("color-skin-1 color-skin-2 color-skin-3 color-skin-4 color-skin-5").addClass(cls);
    });

    $(".color-pattern").click(function () {
        var bgim = $(this).css("background-image");
        $(".color-pattern").removeClass("active");
        $(this).addClass("active");
        $(".retouch-background").css("background-image", bgim);
    });

    $("#wide").click(function (event) {
        event.preventDefault();
        $("body").removeClass("boxed retouch-background").addClass("wide");
        $(window).resize();
    });

    $("#boxed").click(function (event) {
        event.preventDefault();
        $("body").removeClass("wide").addClass("boxed retouch-background");
        $(window).resize();
    });
});
