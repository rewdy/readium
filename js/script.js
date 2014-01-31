/*

Readium Theme
-------------

script.js

Readium theme javascript. Uses jQuery (obviously).

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

	// Set pageTop variable for other functions to use
	window.pageTop = jQuery('html,body').scrollTop();
	jQuery(window).scroll(function(){
		window.pageTop = jQuery(window).scrollTop();
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

jQuery(window).load(function(){
	// Various items come in the load section because if images aren't loaded, there will be issues in calculating offsets.

	// Parallax effect on header image
	var headerHeight = jQuery('#site-header').not('.no-image').height();
	var backgroundOffset = 0;
	if (headerHeight) {
		// cache the items we're working with to reduce lag
		$siteHeader = jQuery('#site-header');
		$pageHeaderOverlay = jQuery('#page-header-overlay');

		// add the scroll events
		jQuery(window).scroll(function(){
			if (state == 'full') {
				if (window.pageTop < headerHeight) {
					// change the offset for the header image
					backgroundOffset = Math.abs(window.pageTop/2) * -1;
					$siteHeader.css('background-position', 'center ' + backgroundOffset + 'px');

					// change the bottom offset for the title text
					titleBottomOffset = (headerHeight-window.pageTop)/4;
					titleMinBottomOffset = 80;
					titleBottomOffset = (titleBottomOffset > titleMinBottomOffset) ? titleBottomOffset : titleMinBottomOffset;
					$pageHeaderOverlay.css('bottom', titleBottomOffset + 'px');
				}
			}
		});
	}

	// Read line
	jQuery('.readline').each(function(){
		var enabled = false;
		var line = jQuery(this);
		var article = jQuery(this).closest('article');
		var articleTop = article.offset().top;
		var articleBottom = articleTop + article.outerHeight();
		var calculationPadding = 400; // this is extra space to add when calculating the percentage because people don't read at the top of their screens.

		// sets the readline accordingly on an interval to keep from bogging down the scroll event
		setInterval(function(){
			var top = window.pageTop;
			if (top >= articleTop && top <= articleBottom) {
				var percentageFinished = Math.round((top - articleTop) / (articleBottom - articleTop - calculationPadding) * 100);
				line.width(percentageFinished + '%');
			} else {
				line.width(0);
			}
		}, 50);
	});
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