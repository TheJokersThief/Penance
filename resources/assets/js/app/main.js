(function($){
  $(function(){

    $('.button-collapse').sideNav();
    $('.parallax').parallax();
    $('.materialboxed').materialbox();
    $('.carousel').carousel();
        

    $(document.body).on('click', 'a[href^="#"]', function (e) {
		e.preventDefault();
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				var offset = 0;
				if (target[0].id.indexOf("feature-") == 0) {
					offset = 100;
				}
				$('html,body').animate({
					scrollTop: target.offset().top - offset
				}, 1000);
				return false;
			}
		}
	});

	setInterval(function(){
		$('.carousel').carousel('next');
	}, 2000);
  }); 
})(jQuery);