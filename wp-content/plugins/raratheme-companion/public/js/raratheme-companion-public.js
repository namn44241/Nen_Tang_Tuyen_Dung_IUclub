jQuery(document).ready(function($) {
	// ! function (d, s, id) {
	//     var js, fjs = d.getElementsByTagName(s)[0],
	//         p = /^http:/.test(d.location) ? 'http' : 'https';
	//     if (!d.getElementById(id)) {
	//         js = d.createElement(s);
	//         js.id = id;
	//         js.src = p + "://platform.twitter.com/widgets.js";
	//         fjs.parentNode.insertBefore(js, fjs);
	//     }
	// }(document, "script", "twitter-wjs");

	$(document).on('click','.expand-faq', function(e){
		e.preventDefault();
		if($(this).children('svg').hasClass('fa-toggle-on')){
			$(this).children('svg').toggleClass('fas fa-toggle-off');
		}
		else if($(this).children('svg').hasClass('fa-toggle-off')){
			$(this).children('svg').toggleClass('fas fa-toggle-on');
		}
		if(!$('.raratheme-faq-holder .inner').hasClass('open'))
		{
			$('.raratheme-faq-holder .inner').addClass('open');
			$('.raratheme-faq-holder li').addClass('show');
			$('.raratheme-faq-holder .inner').slideDown('slow');
		}
		else
		{
			$('.raratheme-faq-holder .inner').removeClass('open');
			$('.raratheme-faq-holder li').removeClass('show');
			$('.raratheme-faq-holder .inner').slideUp('slow');
		}
	});
	$('.faq-answer').slideUp();
	$('.toggle').on('click',function(e) {
	  	e.preventDefault();
	  
	    var $this = $(this);
	  
	    if ($this.parent().hasClass('show')) {
	        $this.parent().removeClass('show');
	        $this.next().slideUp(350);
	    } 
	    else
	    {
	        $this.parent().removeClass('show');
	        $this.next().slideUp(350);
	        $this.parent().toggleClass('show');
	        $this.next().slideToggle(350);
	    }
	});
    
    var $grid = $('body:not(.single) .portfolio-img-holder').imagesLoaded( function(){    
        $grid.isotope({
    		itemSelector: '.portfolio-item',
    		percentPosition: true,
    	});
    
    	// filter items on button click
    	$('.portfolio-sorting').on('click', 'button', function() {
    		var filterValue = $(this).attr('data-sort-value');
    		$grid.isotope({ filter: filterValue });
    	});
    	// change is-checked class on buttons
    	$('.portfolio-sorting').each(function(i, buttonGroup) {
    		var $buttonGroup = $(buttonGroup);
    		$buttonGroup.on('click', 'button', function() {
    			$buttonGroup.find('.is-checked').removeClass('is-checked');
    			$(this).addClass('is-checked');
    		});
    	});
    });
});
