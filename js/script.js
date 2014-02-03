/*

Readium Theme
-------------

script.js

Readium theme javascript.

*/

/**
 * Inits and bindings
*/
var state;
jQuery(function(){
	// Drawer toggle
	jQuery('#navigation-toggle-link').click(function(){
		if (!jQuery('#control').hasClass('open')) {
			toggleDrawer('open');
		} else {
			toggleDrawer('close');
		}
		return false;
	});
	
	// Set up the link to the content
	jQuery('#content-link').click(function(){
		var destinationSel = jQuery(this).attr('href');
		var contentTop = jQuery(destinationSel).offset().top;
		jQuery('body,html').animate({
			scrollTop:contentTop
		}, 700);
		return false;
	});

	// some js for responsiveness
	setWindowSizeClasses() // the the classes initially
	var sized;
	jQuery(window).resize(function(){
		clearTimeout(sized);
		sized = setTimeout(setWindowSizeClasses, 200);
	})

	// lightbox init
	initLightbox();

	initSharing();
});

/**
 * Helper Functions
*/
function toggleDrawer(way) {
	if (way == 'open') {
		jQuery('#control').addClass('open');
		setTimeout(function(){
			jQuery('#page').one('click', function(){
				jQuery('#control').removeClass('open');
			});
		},500);
	} else if (way == 'close') {
		jQuery('#control').removeClass('open');
	}
}

// sets classes for the size of the window
function setWindowSizeClasses() {
	var winWidth = jQuery(window).width();
	if (winWidth > 640) {
		state = 'full';
		jQuery('body').addClass('full').removeClass('mobile');
	} else {
		state = 'mobile';
		jQuery('body').addClass('mobile').removeClass('full');
	}
}

function initLightbox() {
	jQuery('.gallery').each(function(index){
		var $gal = jQuery(this);
		var galId = $gal.attr('id');
		var $galleryLinks = $gal.find('.gallery-icon a').filter("[href$='.jpg'], [href$='.gif'], [href$='.png']");
		$galleryLinks.each(function(){
			if (jQuery(this).attr('title')!='') {
				$link = jQuery(this);
				var title = $link.find('img').attr('alt');
				$link.attr('title', title);
			}
		});
		$galleryLinks.attr('data-lightbox-gallery', galId);
		$galleryLinks.nivoLightbox();
	});
}

// set up the sharing behavior
function initSharing() {
	jQuery('.sharing-list a').not('.email, .pinterest').click(function(){
		href = jQuery(this).attr('href');
		openWindow(href, 'Share');
		return false;
	});
	jQuery('.sharing-list a.pinterest').click(function(){
		faLoadingIndicator(jQuery(this), 'fa-pinterest', 2000);
		pinterestPinIt();
		return false;
	});
}

// function to open urls in a new window (used for sharing)
function openWindow(url, title) {
	var winWidth = 700;
	var winHeight = 450;
	var left = (screen.width/2)-(winWidth/2);
	var top = (screen.height/2)-(winHeight/2);
	window.open(
		url, // url
		title, // window name
		'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, height='+winHeight+', width='+winWidth+', left='+left+', top='+top
	);
}

// pinterest action
function pinterestPinIt() {
	var e = document.createElement('script');
	e.setAttribute('type','text/javascript');
	e.setAttribute('charset','UTF-8');
	e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
	document.body.appendChild(e);
}

// show font awesome loading indicator
function faLoadingIndicator($el, iconClass, duration) {
	$icon = $el.find('.fa');
	$icon.removeClass(iconClass);
	$icon.addClass('fa-spinner').addClass('fa-spin');
	setTimeout(function(){
		$icon.removeClass('fa-spinner').removeClass('fa-spin');
		$icon.addClass(iconClass);
	}, duration);
}