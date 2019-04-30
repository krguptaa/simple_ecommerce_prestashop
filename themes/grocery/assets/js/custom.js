/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */
$(document).ready(function() {
	$('.main-nav > li:has(ul)').addClass('hassub');
	
	$(".top-left").html($(".social-links").clone());
	$(".top-right").prepend($(".login-links, .lang-links").clone());
	$(".search-mobile .container").prepend($(".top-search").clone());
	$(".main-menu-mob .col-7").prepend($(".cart-links").clone());
	
	
	$(".search").click(function() {
        $("body").toggleClass("search-open");
    });
	
	$(".mobile-btn, .bgdark").click(function() {
       $("body").toggleClass("menu-open");  
    });
	
	
	
});	
	
function scriptdesktop(){
	$("li.hassub").mouseenter(function() {
				$("body").addClass("menu-up");
			});
			$("li.hassub").mouseleave(function() {
				$("body").removeClass("menu-up");
			});
			
			$(".main-nav *").removeAttr("style");
}
function scriptmobile(){
	$(".hassub > a").click(function(e) {
                e.preventDefault();
				$(this).siblings("ul").slideToggle();
				$(this).parent().siblings("li").slideToggle();
				$(this).parent().toggleClass("active");
            });
	
	$(".main-nav > li > ul > li > a").click(function(e) {
        e.preventDefault();
		$(this).siblings(".big-sub").slideToggle();
    });
	$(".menu-sec > h3").click(function(e) {
        e.preventDefault();
		$(".menu-sec > ul").slideUp();
		$(this).siblings("ul").slideToggle();	
    });
}
	
$(document).ready(function() {
	if ($(window).width() > 1199) {
			scriptdesktop();
		}
		else{
			scriptmobile();
		}
});

$(window).resize(function() {
	$.doTimeout( 'resize', 250, function(){
		if ($(window).width() > 1199) {
			scriptdesktop();
		}
		else{
			scriptmobile();
		}	
	});	
});

