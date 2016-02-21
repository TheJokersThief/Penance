(function($){
  $(function(){

  	$('.tooltipped').tooltip({delay: 50});
        
  	// Smooth scroll for links on the current page
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

    // Allow toasts to be dismissed with a click
	$(document).on('click', '#toast-container .toast', function() {
	    $(this).fadeOut(function(){
	        $(this).remove();
	    });
	});

	// Setup all ajax queries to use the CSRF token
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
  }); 
})(jQuery);