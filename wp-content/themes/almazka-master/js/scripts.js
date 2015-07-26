$(document).ready(function(){

/* prettyPhoto */

if($("a[rel^='prettyPhoto']").length > 0){
	$("a[rel^='prettyPhoto']").prettyPhoto({
	animation_speed: 'fast', /* скорость анимации про загрузке и смене фото, значение fast, slow или normal */
	autoplay_slideshow: true, /* разрешить слайд шоу, значение true или false */
	slideshow: 3000, /* false или интервал в миллисекундах (работает если autoplay_slideshow: true)*/
	opacity: 0.60, /* Сила затемнения, (допустимые значения от 0.1 до 1) 0.1 - самое слабое, 1 - самое сильное */
	show_title: true, /* Показывает наименование товара, значение true или false */
	default_width: 500,
	autoplay_slideshow: false,
	default_height: 500,
	counter_separator_label: ' из ', /* разделитель для счётчика, по умолчанию косая черта (слэш) "/" */
	theme: 'facebook', /* указываем тему: light_rounded, dark_rounded, light_square, dark_square или facebook */
	modal: false, /* если установлено значение True, закрыть окно можно только по нажатию "Закрыть" */
	social_tools: false
});
}

/* end of prettyPhoto */

/* filter image block */
if($('#container').length > 0){
	$('#container').mixItUp();
}
/* end of filter image block */


/* ancor */

$('a[href*=#]').bind("click", function(e){
		 var anchor = $(this);
		 $('html, body').stop().animate({
				scrollTop: $(anchor.attr('href')).offset().top-50
		 }, 1000);
		 e.preventDefault();
	});

/* end of ancor */

});