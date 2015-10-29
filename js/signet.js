var hcycledur = 6000, hcycler, fcycledur = 7000, fcycler, hflashloc;

function signetNextHomeSlide() {
	var onn = jQuery('#hdots a.on');
	var n = onn.next();
	if ( n.hasClass('r') ) n = jQuery('#hdots a:first');
	n.click();
}

function signetNextFSlide() {
	var onn = jQuery('#fdots a.on');
	var n = onn.next();
	if ( n.size() == 0 ) n = jQuery('#fdots a:first');
	n.click();
}

function signetSlidesIn() {
	jQuery('#home .slide:first').fadeIn(400, function() {
		jQuery(this).addClass('on');
	});
	if ( jQuery('#hdots a').size() >  1 ) {
		jQuery('#hdots a:first').addClass('on');
		hcycler = setTimeout(signetNextHomeSlide, hcycledur);
	}
}

function signetHideFlash() {
	jQuery('#hflash').remove();
	try {
		jQuery.cookies.set( 'signetflashed', true );
	} catch(err) {
		//
	}
	signetSlidesIn();
}

jQuery(function($) {
	$('.special_search').val('Search').bind({
		focus: function() {
			if($(this).val() == 'Search') $(this).val('');
		},
		blur: function() {
			if($(this).val() == '') $(this).val('Search');
		}
	});
	
	$("#labtech.resources_bar .children li a, #generic.resources_bar .children li a, .blog_widget ul li a").prepend('-  ');
	
	$("#menu-languages").hover(function () {
		$('.widget-language .sub-menu').stop(true,true).slideToggle();
	});
	
	// nav
	$('#access a').bind('mouseover', function() {
		$(this).parent().addClass('over');
		$(this).next().show();
	}).parent().bind('mouseleave',function() {
		$(this).removeClass('over').children('ul').hide();
	});
	
	$('#access ul.sub-menu:first').append('<li class="info e" />').children().children().each(function(i) {
		$(this).data('t',$(this).attr('title'));
		$(this).attr('title','');
		$(this).bind({
			mouseover: function() {
				var c = 'k' + (i+1);
				var t = '<span>'+ $(this).data('t') +'</span>';
				/*
				var ta = t.split(' ');
				var tl = ta.length;
				var th = Math.ceil(tl/2);
				var h1 = (ta.slice(0,th)).join(' ');
				var h2 = (ta.slice(th)).join(' ');
				t = '<span>'+h1+'<br />'+h2+'</span>';
				*/
				$(this).parent().siblings('li.info').addClass(c).removeClass('e').html(t);
				return false;
			},
			mouseleave: function() {
				var c = 'k' + (i+1);
				$(this).parent().siblings('li.info').removeClass(c).addClass('e').empty();
			}
		});
	});
	
	// footer collapse
	$('#footer a.collapse').click(function() { 
		if ( $(this).parent().hasClass('closed') ) {
			$(this).parent().removeClass('closed');
		}
		$(this).siblings('.inside').slideToggle(400, function() {
			if ( $(this).parent().hasClass('open') ) {
				$(this).parent().addClass('closed');
			}
			$(this).parent().toggleClass('open');
		});
		return false;
	});
	
	// TODO
	if ( $('#home').size() > 0 ) {
		// homepage slides
		$('#hdots a').each(function(i) {
			$(this).click(function() {
				if( $(this).hasClass('on') == false ) {
					clearTimeout(hcycler);
					$(this).addClass('on').siblings('.on').removeClass('on');
					$(this).parent().parent().children('.slide:eq('+i+')').show()
						.siblings('.on').fadeOut(800,function() {
							$(this).removeClass('on').siblings('.slide:visible').addClass('on');
						});
					hcycler = setTimeout(signetNextHomeSlide, hcycledur);
				}
				return false;
			});
		});
		
		// check cookie for homepage flash
		if ( jQuery.cookies.get( 'signetflashed' ) ) {
			signetSlidesIn();
		} else {
			// draw flash, and then start slide cycle after flash is done
			$('#home').append('<div id="hflash" />');
			var flashvars = {};
			var params = {
				wmode: 'opaque',
				loop: 'false'
			};
			var attributes = {
				wmode: 'opaque'
			};

			swfobject.embedSWF(hflashloc, "hflash", "900", "456", "9.0.0", flashvars, params, attributes);
			hcycler = setTimeout(signetHideFlash, 9000);
		}
		// (homepage) footer image toggle
		$('#fdots a').each(function(i) {
			$(this).click(function() {
				if ( $(this).hasClass('on') == false ) {
					clearTimeout(fcycler);
					$(this).addClass('on').siblings('.on').removeClass();
					$(this).parent().parent().children('.fslide:eq('+i+')').show()
						.siblings('.on').fadeOut(800,function() {
							$(this).removeClass('on').siblings('.fslide:visible').addClass('on');
						});
					fcycler = setTimeout(signetNextFSlide, fcycledur );
				}
				return false;
			});
		});
		fcycler = setTimeout(signetNextFSlide, fcycledur );
	}
	// newsletter signup
	// cookie footer collapse?
});
