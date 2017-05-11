/*----------MAP-----------*/
	function generateMap(latitude, longitude){
		if ($('#map').size()) {
			ymaps.ready(init);

			function init () {
				// Создание экземпляра карты и его привязка к контейнеру с
				// заданным id ("map")
				var myMap = new ymaps.Map('map', {
						// При инициализации карты, обязательно нужно указать
						// ее центр и коэффициент масштабирования
						center: [latitude,longitude],  
						zoom: 16
					});
				// Создание метки 
				var myPlacemark = new ymaps.Placemark(
					// Координаты метки
				[latitude,longitude] , {
				}, {
					iconImageHref: 'img/ic_map.png', // картинка иконки
					iconImageSize: [37, 42], // размеры картинки
					iconImageOffset: [-18, -40] // смещение картинки
				});
				myMap.controls.add(
					new ymaps.control.ZoomControl()
				);
				// Добавление метки на карту
				myMap.geoObjects.add(myPlacemark);
			}
		}
	}
	
$(document).ready(function(){ 
	

	$('.tbl_free td').on( 'click', function() {
		if ($(this).closest('tr').hasClass('tbl_hidden')) {

		}
		else {
			$(this).closest('tr').toggleClass('active');
			$(this).closest('tr').next('.tbl_hidden').toggleClass('active');
		}
	});

	$(".list_photo a").fancybox();

	$(window).scroll(function () {
		var position = $('.header_top').height() + $('.header_btn').height() + 39;
			
		if ($(this).scrollTop() > position) {
			$('#header nav , .menu').addClass('fixed');
		} else {
			$('#header nav, .menu').removeClass('fixed');
		}
	});
	(function (){
	// зафиксированно главное меню
	var lastId,
		topMenu = $(".menu"),
		topMenuHeight = topMenu.outerHeight(),
		menuItems = topMenu.find("a"),
		scrollItems = menuItems.map(function(){
			var item = $($(this).attr("href"));
			if (item.length) { return item; }
		});
		menuItems.click(function(e){
		  var href = $(this).attr("href"),
			  offsetTop = href === "#" ? 0 : $(href).offset().top - $('#header nav').height() + 2;
		  topMenu.removeClass('active');
		  $('.open_menu').removeClass('active');
		  $('html, body').stop().animate({ 
			  scrollTop: offsetTop
		  }, 500);
		  $(this).removeClass('active');
		  e.preventDefault();
		});
		$(window).scroll(function(){
		   var fromTop = $(this).scrollTop() + $('#header nav').height();
		   var cur = scrollItems.map(function(){
			 if ($(this).offset().top < fromTop)
			   return this;
		   });
		   cur = cur[cur.length-1];
		   var id = cur && cur.length ? cur[0].id : "";
		   
		   if (lastId !== id) {
			   lastId = id;
			   menuItems
				 .parent().removeClass("active")
				 .end().filter("[href=#"+id+"]").parent().addClass("active");
				 Index= 0;
			
		   }
		});
	 }());

	// попап
	$('.open_popup').on( 'click', function() {
		var src = $(this).attr('data-id-popup'),
			ScrollWidht = getScrollbarWidth();
		if (document.getElementById(src)) {
			$('#' + src).addClass('active');
			$('body').addClass('hidden').css({
				marginRight: ScrollWidht
			});
		}
		return false;
	});

	/*width scroll*/
	function getScrollbarWidth() {
		var outer = document.createElement("div");
		outer.style.visibility = "hidden";
		outer.style.width = "100px";
		document.body.appendChild(outer);
		var widthNoScroll = outer.offsetWidth;
		// force scrollbars
		outer.style.overflow = "scroll";
		// add innerdiv
		var inner = document.createElement("div");
		inner.style.width = "100%";
		outer.appendChild(inner);        
		var widthWithScroll = inner.offsetWidth;
		// remove divs
		outer.parentNode.removeChild(outer);
		return widthNoScroll - widthWithScroll;
	}

	$('.clouse_popup, .popup').on( 'click', function() {
		$('.popup').removeClass('active');
		setTimeout(function() {
			$('body').removeClass('hidden').css({
				marginRight: 0
			});
		}, 400);
		return false;
	});
	$('.popup_box').on( 'click', function(e){e.stopPropagation();});
	// конец попап



	// навигация с якорями
	$('.btn_scroll').on( 'click', function() {
		var src = $(this).attr('href'),
			postion = $('#' + src).offset().top;
		if (document.getElementById(src)) {
			 $('body,html').animate({
			scrollTop: postion
		}, 400);
		}
		return false;
	});

	$('.open_menu').on( 'click', function() {
		$(this).toggleClass('active');
		$('.menu').toggleClass('active');
		return false;
	});

});