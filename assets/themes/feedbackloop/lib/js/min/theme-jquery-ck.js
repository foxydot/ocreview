jQuery(document).ready(function($){$("*:first-child").addClass("first-child"),$("*:last-child").addClass("last-child"),$("*:nth-child(even)").addClass("even"),$("*:nth-child(odd)").addClass("odd");var e=$("#footer-widgets div.widget").length;$("#footer-widgets").addClass("cols-"+e),$(".ftr-menu ul.menu>li").after(function(){return!$(this).hasClass("last-child")&&$(this).hasClass("menu-item")&&"none"!==$(this).css("display")?'<li class="separator">|</li>':void 0}),$(".gform_footer").append(function(){return $(this).parent().find(".gform_body .move-to-gform-footer")});var t=$(".site-header .wrap .header-widget-area .gform_widget .gform_wrapper");$(".site-header .wrap .header-widget-area .gform_widget .widget-title,.site-header .gform_widget .gform_post_footer .button,.site-header .gform_widget .gform_post_footer .button").click(function(){t.hasClass("open_form")?t.removeClass("open_form"):t.addClass("open_form")})});