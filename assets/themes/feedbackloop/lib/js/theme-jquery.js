jQuery(document).ready(function($) {	
    $('*:first-child').addClass('first-child');
    $('*:last-child').addClass('last-child');
    $('*:nth-child(even)').addClass('even');
    $('*:nth-child(odd)').addClass('odd');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	
	//special for lifestyle
	$('.ftr-menu ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!=='none'){
			return '<li class="separator">|</li>';
		}
	});
	
    $('.gform_footer').append(function(){
        return $(this).parent().find('.gform_body .move-to-gform-footer');
    });
    
    var formwrapper = $('.site-header .wrap .header-widget-area .gform_widget .gform_wrapper');
    $('.site-header .wrap .header-widget-area .gform_widget .widget-title,.site-header .gform_widget .gform_post_footer .button,.site-header .gform_widget .gform_post_footer .button').click(function(){
        if(!formwrapper.hasClass('open_form')){
            formwrapper.addClass('open_form');
        } else {
            formwrapper.removeClass('open_form');
        }
    });
});
