$(function(){
	$('#menuSuperior ul >li').hover(
		function(){
			$('.submenu',this).stop(true,true).slideDown('fast');
			$(this).addClass('activo');
		},
		function(){
			//$('.submenu',this).slideUp('fast');
			$('.submenu',this).hide();
			$(this).removeClass('activo');
		}
	);
});