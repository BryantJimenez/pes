(function($) {

	"use strict";

	$('[data-toggle="tooltip"]').tooltip();

 	// loader
 	var loader = function() {
 		setTimeout(function() { 
 			if($('#ftco-loader').length>0) {
 				$('#ftco-loader').removeClass('show');
 			}
 		}, 1);
 	};
 	loader();

 	$('.int').keypress(function() {
 		return event.charCode >= 48 && event.charCode <= 57;
 	});

 	// Lazy load
 	if($('.lazy').length) {
 		var lazyLoadInstance=new LazyLoad({
 			elements_selector: ".lazy"
 		});
 	}

	// Footer collapse
	if($('footer').length) {
		var headingFooter=$('footer h3');
		$(window).resize(function() {
			if($(window).width() <= 768) {
				headingFooter.attr("data-toggle","collapse");
			} else {
				headingFooter.removeAttr("data-toggle","collapse");
			}
		}).resize();
		headingFooter.on("click", function () {
			$(this).toggleClass('opened');
		});
	}

	// Opacity mask
	if($('.opacity-mask').length) {
		$('.opacity-mask').each(function(){
			$(this).css('background-color', $(this).attr('data-opacity-mask'));
		});
	}

	// Secondary fixed
	if($('.sticky_horizontal').length) {
		$('.sticky_horizontal').stick_in_parent({
			offset_top: 0
		});
	}

	// Secondary scroll
	if($('.secondary_nav').length) {
		$('.secondary_nav').find('a').on('click', function(e) {
			e.preventDefault();
			var target = this.hash;
			var $target = $(target);
			$('html, body').animate({
				'scrollTop': $target.offset().top - 60
			}, 700, 'swing');
		});
	}

	// Sticky sidebar
	if($('#sidebar_fixed').length) {
		$('#sidebar_fixed').theiaStickySidebar({
			minWidth: 991,
			updateSidebarHeight: false,
			containerSelector: '',
			additionalMarginTop: 90
		});
	}

	// Drodown options prevent close
	if($('.dropdown-options').length) {
		$('.dropdown-options .dropdown-menu').on("click", function(e) { e.stopPropagation(); });
	}

	//dropify para input file más personalizado
	if ($('.dropify').length) {
		$('.dropify').dropify({
			messages: {
				default: 'Arrastre y suelte una imagen o da click para seleccionarla',
				replace: 'Arrastre y suelte una imagen o haga click para reemplazar',
				remove: 'Remover',
				error: 'Lo sentimos, el archivo es demasiado grande'
			},
			error: {
				'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} máximo).',
				'minWidth': 'El ancho de la imagen es demasiado pequeño ({{ value }}}px mínimo).',
				'maxWidth': 'El ancho de la imagen es demasiado grande ({{ value }}}px máximo).',
				'minHeight': 'La altura de la imagen es demasiado pequeña ({{ value }}}px mínimo).',
				'maxHeight': 'La altura de la imagen es demasiado grande ({{ value }}px máximo).',
				'imageFormat': 'El formato de imagen no está permitido (Debe ser {{ value }}).'
			}
		});
	}
})(jQuery);

// Sticky nav
if($('.element_to_stick').length) {
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 1) {
			$('.element_to_stick').addClass("sticky");
		} else {
			$('.element_to_stick').removeClass("sticky");
		}
	});
	$(window).scroll();
}

// Menu
$('a.open_close').on("click", function () {
	$('.main-menu').toggleClass('show');
	$('.layer').toggleClass('layer-is-visible');
});
$('a.show-submenu').on("click", function () {
	$(this).next().toggleClass("show_normal");
});

// Scroll to top
if($('#toTop').length) {
	var pxShow = 800; // height on which the button will show
	var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.
	$(window).scroll(function(){
		if($(window).scrollTop() >= pxShow){
			$("#toTop").addClass('visible');
		} else {
			$("#toTop").removeClass('visible');
		}
	});
	$('#toTop').on('click', function(){
		$('html, body').animate({scrollTop:0}, scrollSpeed);
		return false;
	});
}

// Reserve Fixed on mobile
if($('.btn_reserve_fixed').length) {
	$('.btn_reserve_fixed a').on('click', function() {
		$(".box_order").show();
	});
	$(".close_panel_mobile").on('click', function (event){
		event.stopPropagation();
		$(".box_order").hide();
	});
}