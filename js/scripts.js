jQuery(document).ready(function($) {
	
	$('.primary-menu .sf-menu').slicknav({
		prependTo:'.menu-section'
	});
	
	jQuery('.primary-menu ul.sf-menu').show();
	jQuery('.primary-menu ul.sf-menu').superfish({	
		hoverClass:  'over', 							
		animation:   {opacity:'show',height:'show'},  
		speed:       150,                          
		autoArrows:  true,    
		dropShadows: true, 
		delay       : 0		
	});	
	
	jQuery("iframe").each(function(){
      var ifr_source = jQuery(this).attr('src');
      var wmode = "wmode=transparent";
      if(ifr_source.indexOf('?') != -1) jQuery(this).attr('src',ifr_source+'&'+wmode);
      else jQuery(this).attr('src',ifr_source+'?'+wmode);
	});
});