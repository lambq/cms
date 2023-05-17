$(document).ready(function(){
	$('.nav .menu ul li').hover(function(){
		if($(this).children('ul').length > 0){
			$(this).children('a').addClass('curmenu');
			$(this).children('ul').addClass('submenu');
		}
	},function(){
		$(this).find('ul').removeClass('submenu').end().find('a').removeClass('curmenu');
	});
	$('.top-other .icon-menu').click(function(){
		$('.nav').toggleClass('mobile-nav');
		$('body').toggleClass('nav-active');
		$(this).parents('li').toggleClass('cur-menu').siblings('li').removeClass('cur-menu');
		$('.search-bg').removeClass('search-open');
		$('.social-share').hide();
	});
	$('.top-other .icon-search').click(function(){
		$('.search-bg').toggleClass('search-open');
		$(this).parents('li').toggleClass('cur-menu').siblings('li').removeClass('cur-menu');
		$('.nav').removeClass('mobile-nav');		
		$('body').removeClass('nav-active');
		$('.social-share').hide();
	});
	$('.top-other .icon-share').click(function(){
		$(this).parent().find('.social-share').fadeToggle('fast');
		$(this).parents('li').toggleClass('cur-menu').siblings('li').removeClass('cur-menu');
		$('.nav').removeClass('mobile-nav');
		$('body').removeClass('nav-active');
		$('.search-bg').removeClass('search-open');
	});
	$('.widget ul li.list').mouseover(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
	});
	$('.fixed-widget .icon-up-open').click(function(){
		$('body,html').animate({scrollTop:0},500);
	});
	$('.nav .menu ul li').each(function(){
		var $_ul = $(this).children('ul');
		if($_ul.length > 0){
			$_ul.children('li').last().css('borderBottom','none');
		}
	});
});